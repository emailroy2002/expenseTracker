<template>
 
    <div>
        <p>
            <router-link :to="{ name: 'messages' }">Messages</router-link> |
            <router-link :to="{ name: 'about-us' }">About Us</router-link>            
        </p>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name:"App",
        props: {}
    }
</script>

