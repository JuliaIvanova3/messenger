<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <index-chat/>
            </div>
            <div class="col-md-8">
                <index-message/>
            </div>
        </div>
    </div>
</template>
<script>

import indexChat from './chats/index-chat'
import indexMessage from './messages/index-message'

export default {
    name: 'dashboard',
    components: {
        indexChat,
        indexMessage
    },
    data() {
        return {
        //
        }
    },
    
}
</script>

<style scoped>

</style>