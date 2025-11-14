<template>
    <div class="login-container">
        <h1>Авторизация</h1>
        <form @submit.prevent="handleLogin">
            <div class="form-group">
                <label for="username">Имя пользователя</label>
                <input type="text" id="username" v-model="username" required />
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" v-model="password" required />
            </div>
            <button type="submit">Войти</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            username: '',
            password: ''
        };
    },
    methods: {
        handleLogin() {

            alert(`Вход выполнен для: ${this.username}`);
        }
    }
};
</script>

<style scoped>
.login-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #ffffff;
}

h1 {
    color: #339AF0;

}

form {
    width: 400px;
    border: 1px solid #909AB4;
    padding: 15px;
    border-radius: 5px;
}

.form-group {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

label {
    color: #909AB4;

}

input {
    padding: 10px;
    border: 1px solid #909AB4;

    border-radius: 5px;
    width: 200px;
}

button {
    padding: 10px 20px;
    width: 100%;
    background-color: #339AF0;

    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #287BB5;

}
</style>