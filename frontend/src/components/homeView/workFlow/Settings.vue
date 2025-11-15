<template>
    <div class="settings-container">
        <div class="name-setting">Подключить Яндекс</div>
        <div class="hint">
            Укажите ссылку на Яндекс, пример
            <a href="https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/">
                https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/
            </a>
        </div>

        <form @submit.prevent="checkURL" class="link-form">
            <input v-model="url" type="url" placeholder="Введите ссылку на Яндекс.Карты" :class="{ 'error': urlError }"
                @input="clearError">
            <div v-if="urlError" class="error-message">{{ urlError }}</div>

            <button type="submit" :disabled="isLoading || !url" :class="{ 'loading': isLoading }">
                <span v-if="!isLoading">Сохранить</span>
                <span v-else class="loading-text">Загрузка...</span>
            </button>
        </form>

        <!-- Модальное окно для ошибок -->
        <div v-if="showModal" class="modal-overlay" @click="closeModal">
            <div class="modal-content" @click.stop>
                <div class="modal-header">
                    <h3>{{ modalType }}</h3>
                    <button class="close-btn" @click="closeModal">×</button>
                </div>
                <div class="modal-body">
                    {{ modalMessage }}
                </div>
                <div class="modal-footer">
                    <button @click="closeModal" class="modal-ok-btn">OK</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            url: '',
            isLoading: false,
            urlError: '',
            showModal: false,
            modalMessage: '',
            modalType: '',
        }
    },
    inject: ['updatePlaceInfo', 'getPlaceURL', 'changeSelectedTab'],
    mounted() {
        this.url = this.getPlaceURL();
    },
    methods: {
        validateURL(url) {
            if (!url.trim()) {
                return 'Введите ссылку';
            }

            try {
                const urlObj = new URL(url);

                if (!urlObj.hostname.includes('yandex')) {
                    return 'Ссылка должна вести на Яндекс';
                }
                if (!urlObj.pathname.includes('/maps/')) {
                    return 'Ссылка должна вести на Яндекс.Карты';
                }
                return null; 
            } catch (error) {
                return 'Некорректный формат ссылки';
            }
        },

        clearError() {
            this.urlError = '';
        },

        showError(message) {
            this.modalType = 'Ошибка';
            this.modalMessage = message;
            this.showModal = true;
        },
        showSuccess() {
            this.changeSelectedTab('Отзывы');
        },
        closeModal() {
            this.showModal = false;
            this.modalMessage = '';
            this.modalType = '';
        },

        async checkURL() {
            const validationError = this.validateURL(this.url);
            if (validationError) {
                this.urlError = validationError;
                return;
            }

            this.isLoading = true;
            this.clearError();

            try {
                const response = await axios.get(`http://localhost?url=${encodeURIComponent(this.url)}`);

                if (response.data.success) {
                    this.updatePlaceInfo(response.data.data, this.url);
                    this.showSuccess('Данные успешно загружены!');
                } else {
                    this.showError(response.data.error || 'Произошла ошибка при загрузке данных');
                }

            } catch (error) {
                let errorMessage = 'Произошла ошибка при подключении';

                if (error.response) {
                    errorMessage = error.response.data?.error || `Ошибка сервера: ${error.response.status}`;
                } else if (error.request) {
                    errorMessage = 'Не удалось подключиться к серверу. Проверьте запущен ли бекенд.';
                } else {
                    errorMessage = error.message;
                }

                this.showError(errorMessage);
            } finally {
                this.isLoading = false;
            }
        }
    }
}
</script>

<style scoped>
.name-setting {
    font-weight: 600;
}

.hint {
    margin-top: 15px;
    font-size: 12px;
    color: #6C757D;
    font-weight: 600;
}

.hint a {
    margin-left: 8px;
    color: #788397;
    text-decoration: underline;
}

.link-form {
    display: flex;
    flex-direction: column;
    max-width: 600px;
}

.link-form input {
    font-size: 12px;
    margin-top: 10px;
    width: 100%;
    height: 15px;
    padding: 10px 14px;
    border: 1px solid #DCE4EA;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.link-form input:focus {
    background-color: #fff;
    border-color: #339AF0;
    outline: none;
    box-shadow: 0 0 0 2px rgba(51, 154, 240, 0.1);
}

.link-form input.error {
    border-color: #e74c3c;
    background-color: #fdf2f2;
}

.error-message {
    color: #e74c3c;
    font-size: 12px;
    margin-top: 5px;
    font-weight: 500;
}

.link-form button {
    cursor: pointer;
    margin-top: 15px;
    width: 130px;
    height: 35px;
    border-radius: 6px;
    color: white;
    background-color: #339AF0;
    border: none;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
}

.link-form button:hover:not(:disabled) {
    background-color: #2b83ca;
    transform: translateY(-1px);
}

.link-form button:disabled {
    background-color: #bdc3c7;
    cursor: not-allowed;
    transform: none;
}

.link-form button.loading {
    background-color: #95a5a6;
}

.loading-text {
    display: flex;
    align-items: center;
    justify-content: center;
}

.loading-text::after {
    content: '';
    width: 12px;
    height: 12px;
    margin-left: 8px;
    border: 2px solid transparent;
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    border-radius: 8px;
    padding: 0;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: modal-appear 0.3s ease-out;
}

@keyframes modal-appear {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
    }

    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 20px 10px;
    border-bottom: 1px solid #eee;
}

.modal-header h3 {
    margin: 0;
    color: #2c3e50;
    font-size: 18px;
}

.close-btn {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #7f8c8d;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.close-btn:hover {
    background-color: #f8f9fa;
    color: #e74c3c;
}

.modal-body {
    padding: 20px;
    color: #2c3e50;
    line-height: 1.5;
}

.modal-footer {
    padding: 10px 20px 20px;
    text-align: right;
}

.modal-ok-btn {
    background-color: #339AF0;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.modal-ok-btn:hover {
    background-color: #2b83ca;
}
</style>