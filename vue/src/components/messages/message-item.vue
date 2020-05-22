<template>
    <div class="message-item" :class="className">
        <div class="message-content content">
            <div class="alert alert-primary">
                <div class="header">
                    <p class="p-from"> <strong> {{message.from}} </strong> </p>
                    <div class="actions" v-if="check">
                        <fa-icon 
                            :icon="['fa', 'pen']"  
                            class="header-icon"
                            @click="editMsg"
                        />
                        <fa-icon 
                            :icon="['fa', 'trash']"  
                            class="header-icon"
                            @click="deleteMsg"
                        />
                     </div>
                </div>
                <p> {{message.text}} </p>
                <div :class="classFloat">
                    <small class="small-date">  {{message.date}} </small>
                    <fa-icon :icon="['fa', 'check']"  v-if="check" />
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'message-item',
    props: {
        // className: {
        //     type: String,
        //     default: ''
        // },
        message: {
            type: Object,
            default: () => {}
        }
    },
    computed: {
        className() {
            return {
                'chat-own': this.message.user_id == this.$auth.user().id,
                'chat-other': this.message.user_id != this.$auth.user().id
            }
        },
        classFloat() {
            return {
                'float-right': this.message.user_id == this.$auth.user().id,
                'float-left': this.message.user_id != this.$auth.user().id
            }
        },
        check() {
            return this.message.user_id == this.$auth.user().id
        }
    },
    methods:{
        editMsg() {
            this.$emit('editMsg', this.message);
        },
        deleteMsg() {
            this.$emit('deleteMsg', this.message.id);
        }
    },
    mounted() {
    }
    
}
</script>

<style scoped>
.message {
    margin-bottom: 16px;
}
.chat-own {
    display: flex;
    justify-content: flex-end;
}
.header {
    display: flex;
    justify-content: space-between;
}
.chat-other {
    display: flex;
    justify-content: flex-start;
}
p {
    margin-bottom: 0;
}
.alert {
    padding: 2px 6px;
}
.p-from {
    font-size: 12px;
}
.small-date {
    font-size: 10px;
}
.header-icon {
    width: 10px;
    margin: 0px 2px;
}

</style>