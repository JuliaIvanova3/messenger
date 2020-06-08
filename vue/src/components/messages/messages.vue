<template>
    <div class="messages" ref="messages">
         <message-item
            v-for="message in message_data.slice().reverse()"
            :key="message.id"
            :message="message"
            @editMsg="editMsg"
            @deleteMsg="deleteMsg"
            />
    </div>
</template>

<script>

import MessageItem from './message-item'



export default {
    name: 'messages',
    props: {
        message_data: {
            type: Array,
            default: () => []
        }
    },
    components: {
      MessageItem
    },
    data() {
        return {
            
        }
    },
    computed: {
    },
    methods: {
        editMsg(data){
            this.$emit('editMsg', data);
        },
        deleteMsg(data) {
            this.$emit('deleteMsg', data);
        },
       
    },
    mounted() {
    }
    
}
</script>