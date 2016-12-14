<template>
    <nav class="card-header" role="navigation">
        <router-link v-bind:to="'/'" v-bind:class="{'active': !name}">首页</router-link></li>
        <router-link v-for="item in menu['category']" v-bind:to="'/' + item.name" v-bind:class="{'active': item.name == name}">{{ item.name }}</router-link>
        <router-link v-for="item in menu['page']" v-bind:to="'/文章/' + item.title" v-bind:class="{'active': item.title == name}">{{ item.title }}</router-link>
    </nav>
</template>
<script>
    import store from 'store'

    export default {
        data: () => {
            return {
                menu: []
            }
        },
        mounted: function () {
            let cache = store.get(this.cache_key)
            if (cache) {
                this.menu = cache
            }
        },
        created: function () {
            this.$http.get("/category").then((response) => {
                let data = response.data
                this.menu = data
                store.set(this.cache_key, response.data)
            })
        },
        computed: {
            name: function () {
                let name = this.$route.params.name
                return name ? name : ''
            },
            cache_key: function () {
                return "menu"
            }
        }
    }
</script>
