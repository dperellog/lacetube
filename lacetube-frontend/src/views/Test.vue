<template>
    <Header></Header>

</template>
<script>
import Header from '../components/Header.vue';
import axios from '@/services/Axios';

export default {
    
    components: {
        Header
    },
    beforeMount(){
        axios.get('/api/activity/1')
             .then(r => console.log('r :>> ', r))
            .catch(e => console.log('e :>> ', e))

        // axios.get('sanctum/csrf-cookie')
        // .then(() => axios.put('/api/course/students/add/3', {users: [11,12,13,10,9]}))
        // .then(r => console.log('r :>> ', r))
        // .catch(e => console.log('e :>> ', e))
    }
}
</script>