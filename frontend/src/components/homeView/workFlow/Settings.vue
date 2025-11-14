<template>
    <div class="settings-container">
        <div class="name-setting">Подключить Яндекс</div>
        <div class="hint"> Укажите ссылку на Яндекс, пример <a href="https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/">https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/</a></div>
        <form @click.prevent="" class="link-form" >
            <input type="url">
            <button>Сохранить</button>
        </form>

        
    </div>
</template>
<script>
export default {
    
}
</script>
<style scoped>

.name-setting{
    font-weight: 600;
}
.hint{
    margin-top: 15px;
    font-size: 12px;
    color: #6C757D;
    font-weight: 600;
}
.hint a{
    margin-left: 8px;
    color: #788397;
    text-decoration: underline;
}
.link-form{
    display: flex;
    flex-direction: column;
}
.link-form input{
    font-size: 12px;
    margin-top: 10px;
    width: 40%;
    max-width: 600px;
    height: 15px;
    padding: 5px 14px;
    border: 1px solid #DCE4EA;
    border-radius: 6px;
}
.link-form input:focus{
    background-color: #fff; 
    border-color: #339AF0; 
    outline: none;
}
.link-form button{
    cursor: pointer;
    margin-top: 15px;
    width: 130px;
    height: 25px;
    border-radius: 6px;
    color: #DCE4EA;
    background-color: #339AF0;
    border: none;
    font-weight: 600;
}
.link-form button:hover{
    background-color: #2b83ca;
}
</style>