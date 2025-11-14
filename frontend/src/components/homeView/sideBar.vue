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
                <button @click="selectTab('Отзывы')" :class="{ active: selectedTab === 'Отзывы'}">Отзывы</button>
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
            selectedTab: "Настройка",
            logo: Logo,
            spanner: Spanner,

        };
    },
    methods: {
        selectTab(tab) {
            this.selectedTab = tab;
            console.log(tab);
        }
    }
};
</script>

<style scoped>
.sidebar-container {
    width: 280px;
    height: 100vh;
    background-color: #F6F8FA;
    padding: 15px;
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
</style>