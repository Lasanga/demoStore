<template>
    <div>
        
    </div>
</template>

<script>
export default {
    name: 'signout',
    created(){
      let token = this.$session.get('accessToken');
      if (token != null) {
          this.$session.destroy();
          localStorage.removeItem('cart');
          this.$router.push('/signin');
      }
  },
}
</script>

