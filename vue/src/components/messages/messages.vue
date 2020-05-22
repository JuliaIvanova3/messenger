<template>
    <div class="messages" ref="messages">
         <message-item
            v-for="message in MESSAGES"
            :key="message.id"
            :message="message"
            @editMsg="editMsg"
            @deleteMsg="deleteMsg"
            />
    </div>
</template>

<script>

import MessageItem from './message-item'

import {mapGetters} from 'vuex'

export default {
    name: 'messages',
    components: {
      MessageItem
    },
    computed: {
        ...mapGetters([
            'MESSAGES'
        ])
    },
    methods: {
        editMsg(data){
            this.$emit('editMsg', data);
        },
        deleteMsg(data) {
            this.$emit('deleteMsg', data);
        },
       
    },
    
}
</script>