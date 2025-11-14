<template>
    <div class="window">
        <SideBar :selectedTab="selectedTab" @SelectTab="selectTab"/>
        <WorkFlow :selectedTab="selectedTab" />
    </div>

</template>
<script>
import SideBar from '@/components/homeView/sideBar.vue';
import WorkFlow from '@/components/homeView/workFlow.vue';

export default {
    data() {
        return {
            selectedTab: 'Настройка'
        }
    },
    methods:{
        selectTab(tab)
        {
            this.selectedTab = tab;
        }
    },
    components: {
        SideBar,
        WorkFlow
    }
};

</script>
<style scoped>
.window {
    display: flex;
}
</style>