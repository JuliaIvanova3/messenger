<template>
    <div class="card">
        <div class="card-header text-secondary" @click="createChat">
            <fa-icon :icon="['fa','plus-circle']"  class="icons" size="1x"/>
            <p class="lead">Create new chat ...</p>
        </div>
        <div class="card-body">
            <chat-item
                v-for="(chat,index) in CHATS"
                :key="index"
                :chat_data="chat"
                @swicthActive="swicthActive"
            />
        </div>
    </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex'
import chatItem from './chat-item'

export default {
    name: 'inex-chat',
    components: {
        chatItem
    },
    data() {
        return {
            activeClass: ''
        }
    },
    computed: {
        ...mapGetters([
            'CHATS'
        ])
    },
    methods: {
        ...mapActions([
            'GET_CHATS_FROM_API',
            'SET_CURRENT_CHAT'
        ]),
        createChat() {
            this.$router.push('/chat/create');
        },
        swicthActive(data) {
            this. SET_CURRENT_CHAT(data)
        }
    },
    mounted() {
        this.GET_CHATS_FROM_API();
    },
    updated() {
        this.swicthActive
    }
}
</script>

<style scoped>
.card {
    height: 630px;
}
.card-header {
    display: flex;
    padding: 0px 12px;
}
.card-body {
    padding: 10px;
    overflow: auto;
}
.icons {
    margin: 8px;
}
.lead {
    margin: 0;
}
</style>

