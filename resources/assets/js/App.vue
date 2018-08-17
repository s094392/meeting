<template>
    <div>
        <h1>Vue Router Demo App</h1>
        <router-link :to="{ name: '/' }">Home</router-link> |
        <router-link :to="{ name: 'hello' }">hello</router-link> |
            <div class="container">
               <router-view></router-view>
        </div>
    </div>
</template>
<script>
export default {};
</script>
