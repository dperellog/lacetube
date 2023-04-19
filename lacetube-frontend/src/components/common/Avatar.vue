<template>
<div :class="size" :style="{ backgroundImage: 'url(' + url + ')' }">

</div>

</template>
<script>
export default {
    props: {
        url : {
            type: String,
            required: true
        },
        size : {
            type: String,
            validator(value) {
                // The value must match one of these strings
                return ['sm', 'md', 'lg', 'xl'].includes(value)
            },
        }

    }
}
</script>
<style scoped>

div{
    display: inline-block;

    border-radius: 50%;

    background-position: center;
    background-size: cover;
}

div.sm{
  height: 3rem;
  width: 3rem;
}

div.md{
  height: 5rem;
  width: 5rem;
}

div.lg{
  height: 9rem;
  width: 9rem;
}

div.xl{
  height: 15rem;
  width: 15rem;
}

</style>