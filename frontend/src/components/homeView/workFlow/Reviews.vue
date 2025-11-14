<template>
    <div class="service-container">
        <div class="name-service"><img :src="mark">Яндекс карты</div>
        <div class="reviews-container">
            <div class="reviews">
                <div class="review-container" v-for="review in 5">
                    <div class="review" >
                        <div class="padding">
                            <div class="review-info-container">
                                <div class="date-branch-container">
                                    <div class="date">12.09.2022 14:22</div>
                                    <div class="branch-office">Филиал 1</div>
                                    <img :src="mark">
                                </div>
                                <div class="rating-stars">
                                    <img :src="filledStar" alt="" v-for="star in 5">
                                </div>
                            </div>
                            <div class="name-phone">
                                <div class="name">Наталья</div>
                                <div class="phone">+7 900 540 40 40</div>
                            </div>
                            <div class="review-body">
                                Так, с чего начать... Разнообразная алкогольная продукция, множество закусок и обычных
                                блюд. Кухня вкусная и
                                Разнообразная, от супа и салатов до мясных продуктов. Персонал молодые девушки,
                                общительная и доброжелательные,
                                всегда подскажут, вовремя принесут и вызовут такси. Отдыхали на летней веранде, свежо и
                                тепло, в общем самое то в
                                жаркую погоду. Сами залы не сильно рассмотрел, но видел что они удобные и просторные.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="total-rating">
                <div class="rating-container">
                    <div class="in-number">4.7</div>
                    <div class="in-stars">
                        <img :src="filledStar" alt="" v-for="star in 5">
                    </div>
                </div>
                <div class="hr"></div>
                <div class="total-reviews">Всего отзывов: 1 145</div>
            </div>
        </div>
    </div>
</template>
<script>
import Mark from "@/assets/svg/mark.svg"
import Star from "@/assets/svg/star.svg"
export default {
    data() {
        return {
            mark: Mark,
            filledStar: Star
        }
    }
}
</script>
<style scoped>
.name-service {
    padding: 5px 8px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid #DCE4EA;
    width: fit-content;
}

.reviews-container {
    margin-top: 10px;
    gap: 20px;
    display: flex;
    justify-content: space-between;
    width: calc(100% - 30px);
}

.reviews {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.review-container {
    display: flex;
    flex-direction: column;
    gap: 30px;
    padding: 13px 0px 13px 15px;
    border: 1px solid #E0E7EC;
    box-shadow: 0px 3px 6px rgba(92, 101, 111, 0.3);
    border-radius: 12px;
}

.review {
    background-color: #F6F8FA;
    min-height: 100px;
    width: 100%;
    border-radius: 12px;
}

.review-info-container {
    display: flex;
    justify-content: space-between;
}

.date-branch-container {
    display: flex;
    gap: 10px;
}

.date,
.branch-office {
    font-size: 12px;
    font-weight: bold;
}

.rating-stars {
    display: flex;
    gap: 3px;
}

.rating-stars img {
    width: 14px;
    height: 14px;
}

.padding {
    padding: 7px 25px 7px 5px;
}

.name-phone {
    margin-top: 15px;
    display: flex;
    align-items: end;
    gap: 12px;
}

.name,
.phone {
    font-weight: bold;
    font-size: 10px;
}

.name {
    font-size: 12px;
}






.total-rating {
    width: 30%;
    max-width: 350px;
    height: 155px;
    border: 1px solid #E0E7EC;
    border-radius: 12px;
    box-shadow: 0px 1px 6px rgba(92, 101, 111, 0.3);
    padding: 15px 15px;
    display: flex;
    flex-direction: column;
    gap: 17px;
}

.rating-container {
    display: flex;
    gap: 10px;
    align-items: end;
}

.rating-container .in-number {
    font-size: 40px;
    font-weight: 500;
    line-height: 35px;
}

.rating-container .in-stars {
    display: flex;
    gap: 8px;
}

.in-stars img {
    width: 24px;
    height: 24px;
}

.hr {
    width: 100%;
    height: 2px;
    background-color: #F1F4F7;
}

.total-reviews {
    font-weight: 600;
    font-size: 12px;
}
</style>