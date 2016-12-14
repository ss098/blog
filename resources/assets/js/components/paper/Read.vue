<template>
    <div>
        <p v-if="message" class="alert">
            {{ message }}
        </p>
        <div v-if="loading">
            <loading class="card-content"></loading>
        </div>
        <div v-else>
            <div class="card-sidebar title">
                <h1>{{ paper.title ? paper.title : title }}</h1>
                <p v-if="paper.created_at">最早发表于{{ format_date }}</p>
                <div v-if="user">
                    <button v-if="!toolbar_show" @click="toolbar_show = !toolbar_show" class="button">
                        显示管理工具栏
                    </button>
                    <p v-else>
                        <router-link :to="'/后台/编辑文章/' + paper.title">
                            编辑文章内容
                        </router-link>
                        <a @click="remove_paper">
                            移动到回收站
                        </a>
                    </p>
                </div>
            </div>
            <div class="card-content" v-if="archive_list && archive_list.length > 1">
                <div class="dropdown">
                    <button class="button">历史版本</button>
                    <div class="dropdown-content" v-for="item in archive_list">
                        <router-link :to="'/文章/' + title + '/' + item.title">{{ item.title }}</router-link>
                    </div>
                </div>
            </div>
            <div class="card-content" v-html="paper.content"></div>
        </div>
    </div>
</template>
<script>
    import Loading from '../layout/Loading.vue'
    import storage from '../../storage'
    import store from 'store'
    import moment from 'moment'

    export default {
        components: {
            Loading
        },
        data: () => {
            return {
                loading: true,
                paper: [],
                message: "",
                toolbar_show: false
            }
        },
        mounted: function () {
            this.get_paper()
        },
        methods: {
            get_paper: function () {
                if (store.has(this.cache_key)) {
                    this.paper = store.get(this.cache_key)
                    this.loading = false
                }
                let category = this.category,
                    self = this
                this.$http.get("/paper", {
                    params: {
                        title: this.title
                    }
                }).then((response) => {
                    if (category == self.category) {
                        self.paper = response.data
                        store.set(self.cache_key, self.paper)
                        self.loading = false
                    }
                })
            },
            remove_paper: function () {
                let id = this.paper.id
                this.$http.delete("/paper/" + id, {params: {
                    token: this.user.token
                }}).then((response) => {
                    if (response.data.success) {
                        this.$router.replace("/")
                    } else {
                        this.message = response.data.message
                    }
                })
            }
        },
        watch: {
            title: function () {
                this.get_paper()
            }
        },
        computed: {
            title: function () {
                let title = this.$route.params.name
                return title ? title : ''
            },
            format_date: function () {
                let time = this.paper.created_at
                let today = moment(),
                    date = moment(time)

                if (today.format("YYYY") == date.format("YYYY")) {
                    return "今年 " + date.format("M 月 D 日")
                } else {
                    return date.format(" YYYY 年 M 月 D 日")
                }
            },
            user: function () {
                return storage.state.user
            },
            cache_key: function () {
                return "paper" + this.title
            }
        }
    }
</script>
