<template>
    <div>
        <input type="text" v-model="keyword">
        <ul v-if="Cars.length > 0">
            <li v-for="car in Cars" :key="car.id" v-text="car.model"></li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            keyword: null,
            Cars: []
        };
    },
    watch: {
        keyword(after, before) {
            this.getResults();
        }
    },
    methods: {
        getResults() {
            axios.get('/livesearch', { params: { keyword: this.keyword } })
                .then(res => this.Cars = res.data)
                .catch(error => {});
        }
    }
}
</script>