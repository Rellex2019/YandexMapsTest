<template>
    <div class="sidebar-container">
        <header>
            <img class="logo" :src="logo" alt="Логотип">
            <div class="account-name">{{ accountName }}</div>
            <div class="hr"></div>
        </header>
        <div class="tabs-container">
            <div class="name-tab"><img :src="spanner">{{ selectedTab }}</div>
            <div class="buttons-container">
                <button @click="selectTab('Отзывы')" :disabled="placeInfo.length === 0" :class="{ active: selectedTab === 'Отзывы'}">Отзывы</button>
                <button @click="selectTab('Настройка')" :class="{ active: selectedTab === 'Настройка'}">Настройка</button>
            </div>

        </div>
    </div>
</template>
<script>
import Logo from "@/assets/svg/logo.svg"
import Spanner from "@/assets/svg/spanner.svg"
export default {
    name: "sideBar",
    data() {
        return {
            accountName: "Кирилл Зятчин",
            logo: Logo,
            spanner: Spanner,

        };
    },
    inject:['getPlaceInfo'],
    computed: {
        placeInfo() {
            return this.getPlaceInfo ? this.getPlaceInfo() : [];
        }
    },
    props:{
        selectedTab:{
            required: true,
            type: String
        }
    },
    methods: {
        selectTab(tab) {
            this.$emit('select-tab', tab);
        }
    }
};
</script>

<style scoped>
.sidebar-container {
    width: 280px;
    height: calc(100vh - 30px);
    background-color: #F6F8FA;
    padding: 15px 15px;
}

header {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100px;
}

.logo {
    margin-left: 15px;
    width: 160px;
}

.account-name {
    margin-top: 15px;
    font-weight: bold;
    color: #6C757D;
}

.hr {
    height: 2px;
    margin-top: auto;
    background-color: #DCE4EA;
}


.tabs-container {
    margin-top: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.name-tab {
    display: flex;
    gap: 14px;
    align-items: center;
    padding: 12px 14px;
    border-radius: 12px;
    background-color: #FFFFFF;
    box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.02);
    font-weight: 500;
}

.buttons-container {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.buttons-container button {
    text-align: start;
    padding: 5px 45px ;
    border-radius: 12px;
    background: none;
    border: none;
    font-weight: 500;
    font-size: 12px;
}
.buttons-container button.active {
    background-color: #FFFFFF;
    box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.02);
}

.buttons-container button[disabled] {
    text-align: start;
    padding: 5px 45px;
    border-radius: 12px;
    background: none;
    border: none;
    font-weight: 500;
    font-size: 12px;
    opacity: 0.6;
    cursor: not-allowed;
}
</style>