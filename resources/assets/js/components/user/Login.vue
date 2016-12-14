<template>
    <div class="card-content">
        <div v-if="status_text['message']" class="alert">
            <p v-for="item in status_text['message']">
                {{ item }}
            </p>
        </div>
        <loading v-if="loading"></loading>
        <div class="inline-block" v-else>
            <p class="text-right">邮箱或名称：<input type="email" v-model="email" autofocus="autofocus"></p>
            <p class="text-right">密码：<input type="password" v-model="password"></p>
            <p class="text-right">
                <button type="submit" class="button" @click="submit">登录</button>
            </p>
        </div>
    </div>
</template>
<script>
    import Loading from '../layout/Loading.vue'
    import storage from '../../storage'

    export default {
        components: {
            Loading
        },
        data: function () {
            return {
                loading: false,
                email: "",
                password: "",
                status_text: false
            }
        },
        methods: {
            submit: function () {
                this.loading = true
                this.status_text = false

                let email = this.email,
                    password = this.password

                this.$http.post("/user/login", {
                    email: email,
                    password: password
                }).then(function (response) {
                    this.loading = false
                    if (response.data.success) {
                        let user = response.data.user
                        storage.commit("set_user", user)

                        this.$router.push("/")
                    } else {
                        this.status_text = response.data
                    }
                }, function (response) {
                    this.loading = false
                    this.status_text = response.data
                })
            }
        }
    }
</script>
