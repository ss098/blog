<template>
    <div class="card">
        <navbar></navbar>
        <div>
            <router-view></router-view>
        </div>
        <copyright></copyright>
    </div>
</template>
<script>
    import Navbar from './layout/Navbar.vue'
    import Copyright from './layout/Copyright.vue'

    export default {
        components: {
            Navbar,
            Copyright
        }
    }
</script>
