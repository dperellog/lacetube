<template>
    <form>
        <div class="input-group border-light">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">{{ currentType.name }}</button>
            <ul class="dropdown-menu">
                <li v-for="tipus in getTypes()"><a class="dropdown-item" href="#" @click.prevent="changeType(tipus)">{{ tipus.name }}</a></li>
            </ul>
            <input type="search" class="form-control" aria-label="Cercar...">
            <button class="btn btn-outline-secondary" type="button"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></button>
        </div>
    </form>
</template>
<script>
export default {
    data() {
        return {
            currentType: { type: 'video', name: 'Video' },
            types: [
                { type: 'video', name: 'Video' },
                { type: 'user', name: 'Usuari' },
                { type: 'course', name: 'Curs' },
                { type: 'activity', name: 'Activitat' }
            ]
        }
    },
    methods: {
        changeType(type) {
            this.currentType = type
        },
        getTypes() {
           return this.types.filter(type => type.type != this.currentType.type )
        }
    }
}
</script>
<style scoped>
.btn, input{
    border-color: rgb(215, 215, 215);
}
</style>