import Vue from 'vue'
import Vuex from 'vuex'
import store from 'store'

Vue.use(Vuex)

// TODO 刷新页面时也检查此用户是否有效

let user = store.get("user")

// 由于用了 store.js 就不叫 store 了
const storage = new Vuex.Store({
    state: {
        user: user
    },
    mutations: {
        set_user: (state, user) => {
            store.set("user", user)
            state.user = user
        }
    }
})

export default storage