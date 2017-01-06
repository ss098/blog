<template>
    <div class="card-content">
        <div v-if="message && message.length" class="alert">
            <p v-for="item in message">
                {{ item }}
            </p>
        </div>
        <loading v-if="loading"></loading>
        <div class="inline-block" v-else>
            <p class="text-right">分类：<select v-model="paper.category">
                <option v-for="item in category_list">{{ item.name }}</option>
            </select></p>
            <p class="text-right">标题：<input type="text" v-model="paper.title"></p>
            <editor v-model="paper.content"></editor>
            <p class="text-right"><input type="checkbox" v-model="paper.page"> 独立页面</p>
            <p class="text-right">
                <button type="submit" class="button" @click="submit">提交</button>
            </p>
        </div>
    </div>
</template>
<script>
    import storage from '../../storage'
    import store from 'store'
    import Editor from '../layout/Editor.vue'

    export default {
        components: {
            Editor
        },
        mounted: function () {
            let user = storage.state.user
            if (!user || !user.token) {
                this.$router.replace("/")
            }

            this.category_list = store.get("menu")["category"]
        },
        data: () => {
            return {
                loading: false,
                paper: {
                    title: "",
                    content: "",
                    category: "",
                    page: 0
                },
                category_list: [],
                message: []
            }
        },
        methods: {
            submit: function() {
                let paper = this.paper

                if (!this.submit_check) {
                    return
                }

                let self = this
                let user = store.get("user")

                this.$http.post('/paper', {paper: paper, token: user.token}).then(function (response) {
                    if (response.data.success) {
                        let paper = response.data.paper
                        this.$router.push('/paper/' + paper.title)
                    } else {
                        self.message = response.data.message
                    }
                })
            }
        },
        computed: {
            user: function () {
                return storage.state.user
            },
            submit_check: function () {
                let item
                let paper = this.paper
                for (item in paper) {
                    if (!paper[item] && (item != "page")) {
                        this.message = ["不允许有未填写字段"]
                        return false
                    }
                }
                this.message = []
                return true
            }
        }
    }
</script>