<template>
    <div class="card-content">
        <div v-if="message && message.length" class="alert">
            <p v-for="item in message">
                {{ item }}
            </p>
        </div>
        <loading v-if="loading"></loading>
        <div class="inline-block" v-else>
            <p class="text-right">分类：<select v-model="paper.category_id">
                <option v-for="item in category_list" v-bind:value="item.id">{{ item.name }}</option>
            </select></p>
            <p class="text-right">标题：<input type="text" v-model="paper.title"></p>
            <editor v-model="paper.markdown"></editor>
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
    import Loading from '../layout/Loading.vue'

    export default {
        components: {
            Editor,
            Loading
        },
        mounted: function () {
            let user = storage.state.user
            if (!user || !user.token) {
                this.$router.replace("/")
            }

            this.category_list = store.get("menu")["category"]
            this.get_archive()
        },
        data: () => {
            return {
                loading: true,
                paper: {
                    title: "",
                    content: "",
                    markdown: "",
                    category_id: 0,
                    page: 0
                },
                category_list: [],
                message: []
            }
        },
        methods: {
            get_archive: function () {
                let self = this
                this.$http.get("/paper", {
                    params: {
                        title: this.title
                    }
                }).then((response) => {
                    self.paper = response.data
                    self.loading = false
                })
            },
            submit: function() {
                let paper = this.paper

                if (!this.submit_check) {
                    return
                }

                let self = this
                let user = store.get("user")

                this.$http.put('/paper/' + paper.id, {paper: paper, token: user.token}).then((response) => {
                        this.$router.push('/文章/' + paper.title)
                    }
                )
            }
        },
        computed: {
            user: function () {
                return storage.state.user
            },
            submit_check: function () {
                let item
                let paper = {
                    title: this.paper.title,
                    category_id: this.paper.category_id,
                    markdown: this.paper.markdown
                }
                for (item in paper) {
                    if (!paper[item]) {
                        console.log(item)
                        this.message = ["不允许有未填写字段"]
                        return false
                    }
                }
                this.message = []
                return true
            },
            title: function () {
                let name = this.$route.params.name
                return name ? name : ''
            },
        }
    }
</script>