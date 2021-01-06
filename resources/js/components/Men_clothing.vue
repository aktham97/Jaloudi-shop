<template>
    <div>
        <h3 class="my-2"> Men´s clothing</h3>
        <div class="list-group">
            <router-link to='/Men/Shirts' class="list-group-item">Shirts</router-link>
            <router-link to='/Men/Pants' class="list-group-item">Pants</router-link>
            <router-link to='/Men/Jackets' class="list-group-item">Jackets</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Men_clothing"
    }
</script>

<style scoped>

</style>
