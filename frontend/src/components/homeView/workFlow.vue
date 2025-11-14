<template>
    <div style="width: 100%;">
        <div class="exit-container">
            <div class="img-container">
                <img :src="exit" alt="Выход">
            </div>
        </div>
        <div class="workflow-container">
            <component :is="selectedComponent"></component>
        </div>
    </div>
</template>
<script>
import Exit from "@/assets/svg/exit.svg"
import Reviews from "./workFlow/Reviews.vue";
import Settings from "./workFlow/Settings.vue";

export default {
    name: "WorkFlow",
    data() {
        return {
            exit: Exit,
        }
    },
    props:{
        selectedTab:{
            required: true,
            type: String
        }
    },
    computed: {
        selectedComponent()
        {
            return this.selectedTab == "Отзывы"? Reviews: Settings;
        }
    },
    components: {
        Settings,
        Reviews,
    }
}
</script>
<style scoped>
.exit-container {
    display: flex;
    justify-content: end;
    height: 75px;
    width: 100%;
    border-bottom: 2px solid #DCE4EA;
}

.img-container {
    margin-right: 45px;
    cursor: pointer;
    height: 100%;
    padding: 0px 20px;
    display: flex;
    align-items: center;
}

.workflow-container {
    margin-top: 18px;
    margin-left: 25px;
}
</style>