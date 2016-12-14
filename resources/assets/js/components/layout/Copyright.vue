<template>
    <footer class="card-footer">
        <span>&copy; {{ year }} 正义的小可爱</span>
        <span>豫 ICP 备 15005862 号</span>
        <span v-if="!user"><router-link v-bind:to="{name: 'login'}">登录</router-link></li></span>
        <span v-else>
            {{ user.name }}
            <router-link v-bind:to="{name: 'paper_create'}">创建文章</router-link>
        </span>
        <span><a @click="clear">清除缓存</a></span>
    </footer>
</template>
<script>
    import moment from 'moment'
    import storage from '../../storage'
    import store from 'store'

    export default {
        computed: {
            year: () => {
                return moment().format("YYYY")
            },
            user: function () {
                return storage.state.user
            }
        },
        methods: {
            clear: function () {
                store.clear()
                storage.commit("set_user", false)
            }
        }
    }
</script>