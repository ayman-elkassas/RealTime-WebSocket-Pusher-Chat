<!--TODO:to make this separated should install vue-loader with compatible version with webpack-->

<!--Todo:html-->
<template src="./chats.html" lang="html"></template>
<!--Todo:css-->
<style src="./chats.css" lang="css"></style>
<!--Todo:js (as a .vue)-->
<script>

    axios=window.axios;

    export default {
        props:{
            'user':{
                type:Object
            }
        },
        data() {
            return{
                allMessages:[],
                newMessage:'',
                users:[],
                typingUser:false,
                typingTimer: ''
            }
        },
        created() {
            //to get all message to prepare it in chat on created vm object
            this.getMessages();

            let vm=this;

            //todo:to get message is broadcast now on channel chats and update chat view
            //todo:this will happen after save message when broadcast message is share on channel and fire event
            //todo:here you listen on firing specific event attached on channel 'chats'
            //todo:may be many events attached on channel
            //debugger;
            window.Echo.join('chats')
                .listen('SendMessageEvent', (e) => {
                    //debugger;
                    //alert(e.message);
                    vm.allMessages.push(e.message);
                })
                .here(user => {
                    vm.users = user;
                })
                .joining(user => {
                    vm.users.push(user);
                })
                .listenForWhisper('typing', user => {
                    vm.typingUser = user;

                    if(this.typingTimer){
                        clearTimeout(this.typingTimer);
                    }
                    this.typingTimer=setTimeout(()=>{
                        this.typingUser=false;
                    },3000);
                })
                .leaving(user => {
                    vm.users = vm.users.filter(u => u.id != user.id);
                })
        },
        methods:{
            getMessages(){
                //make object as outer scope for axios (اكسى يوس) used scoping
                let vm=this;
                //get response (who send, and message)
                axios.get('messages').then(response=>{
                    vm.allMessages=response.data;
                });
            },
            saveMessage(){
                //todo:to handle design chat
                // debugger;
                let vm=this;
                this.allMessages.push({
                    user:vm.user,
                    message:vm.newMessage
                });

                //todo:to send newMessage and save
                axios.post('messages',{message:vm.newMessage}).then(response=>{
                    console.log(response.data);
                });

                this.newMessage = '';
            },
            getTypingEvent(){
                let vm=this;
                window.Echo.join('chats')
                    .whisper('typing',vm.user);
            }
        }
    }
</script>
