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
            selectedTab: 'Настройка',
            placeInfo: [],
            placeURL: '',
        }
    },
    provide()
    {
        return{
            updatePlaceInfo: this.updatePlaceInfo,
            changeSelectedTab: this.changeSelectedTab,
            getPlaceURL: () => this.placeURL,
            getPlaceInfo: () => this.placeInfo,
        }
    },
    methods:{
        selectTab(tab)
        {
            this.selectedTab = tab;
        },
        updatePlaceInfo(info, url)
        {
            this.placeURL = url;
            this.placeInfo = info;
            console.log(url);
            console.log(this.placeInfo);
        },
        changeSelectedTab(newTab)
        {
            this.selectedTab = newTab;
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