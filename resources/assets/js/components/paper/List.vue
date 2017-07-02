<template>
    <div>
        <div v-if="loading">
            <loading class="card-content"></loading>
        </div>
        <div v-if="!loading">
            <div class="card-content paper-list-item" v-for="item in paper_list['data']">
                <p><router-link :to="'/paper/' + item.title">
                    {{ item.title }}
                </router-link></p>
                <span class="small-text">
                    最早发表于{{ fotmat_time(item.created_at) }}
                </span>
            </div>
            <ul class="pagination" v-if="paper_list['last_page'] > 1">
                <!-- Vue Router 会对中文路由编码，所以采用拼接路由的方案 -->
                <li><router-link :to="'/' + category + '?page=' + 1" v-if="page > 1">&laquo;</router-link><a disabled v-else>&laquo;</a></li>
                <li v-for="i in range_page(page)">
                    <router-link :to="'/' + category + '?page=' + i">{{ i }}</router-link>
                </li>
                <li><router-link :to="'/' + category + '?page=' + paper_list['last_page']" v-if="page < paper_list['last_page']">&raquo;</router-link><a disabled v-else>&raquo;</a></li>
            </ul>
        </div>
    </div>
</template>
<script>
    import Loading from '../layout/Loading.vue'
    import moment from 'moment'
    import store from 'store'

    export default {
        components: {
            Loading
        },
        data: () => {
            return {
                loading: true,
                paper_list: {
                    last_page: 1
                }
            }
        },
        mounted: function () {
            this.get_paper_list()
        },
        methods: {
            get_paper_list: function () {
                let cache = store.get(this.cache_key)
                if (cache) {
                    this.paper_list = cache
                    this.loading = false
                } else {
                    this.loading = true
                }

                let self = this
                let category = this.category,
                    page = this.page
                this.$http.get("/paper", {
                    params: {
                        category_name: category,
                        page: page
                    }
                }).then((response) => {
                    if (category == this.category) {
                        self.loading = false
                        self.paper_list = response.data

                        store.set(this.cache_key, response.data)
                    }
                })
            },
            range: function (start, stop) {
                let array = new Array();
                for(let i = start; i <= stop; i++)
                {
                    array.push(i)
                }
                return array
            },
            range_page: function (page) {
                let start = page - 5
                let stop = page + 5
                let last_page = this.paper_list['last_page']
                if (start < 1) {
                    start = 1
                }
                if (stop > last_page) {
                    stop = stop > 1 ? last_page : 1
                }
                return this.range(start, stop)
            },
            fotmat_time: function (time) {
                let today = moment(),
                    date = moment(time)

                if (today.format("YYYY") == date.format("YYYY")) {
                    return "今年 " + date.format("M 月 D 日")
                } else {
                    return date.format(" YYYY 年 M 月 D 日")
                }
            }
        },
        watch: {
            category: function () {
                this.get_paper_list()
            },
            page: function () {
                this.get_paper_list()
            }
        },
        computed: {
            category: function () {
                let name = this.$route.params.name
                return name ? name : ''
            },
            page: function () {
                let page = this.$route.query.page
                return page ? page : 1
            },
            cache_key: function () {
                return "list" + this.page + this.category
            }
        }
    }
</script>
