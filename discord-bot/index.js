/* eslint-disable no-unused-vars */
// Require the necessary discord.js classes
const { Client, Intents } = require('discord.js');
const { token } = require('./config.json');
const request = require('request');

// Create a new client instance
const client = new Client({ intents: [Intents.FLAGS.GUILDS] });

// When the client is ready, run this code (only once)
client.once('ready', () => {
	console.log('ready');
});

// eslint-disable-next-line no-unused-vars
function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * 
        charactersLength));
    }
    return result;
}

client.on('interactionCreate', async interaction => {
	if (!interaction.isCommand()) return;
	const { commandName } = interaction;
    var command_status = { status: "success" };
    var user_verifying = { };
    var user_verifying_arr = [];

	if (commandName === 'verify') {
        // console.log(arraySearch(user_verifying, interaction.user.id));
        // user_verifying[interaction.user.id] = { code: makeid(10), verified: false };

        if(user_verifying_arr[interaction.user.id] == null) {
            user_verifying_arr.push({ id: interaction.user.id, code: makeid(10), verified: false });
            let obj = user_verifying_arr.find(o => o.id === interaction.user.id);
            await interaction.reply({ 
                content: 'Your verification code is: `' + obj.code + '`\n\nTo verify your account, go to your channel settings @ https://subrock.rocks/ then set your bio as the code above. \nThen, type `/verify_confirm` to verify your account.', 
                ephemeral: true 
            });
        } else {
            await interaction.reply({ 
                content: 'You have already verifying your account.', 
                ephemeral: true 
            });
        }

        console.log(user_verifying_arr);
	} else if (commandName === 'verify_confirm') {
        console.log(user_verifying_arr); 
        if(user_verifying_arr[interaction.user.id] == null) {
            await interaction.reply({ 
                content: 'You have not ran the `/verify` command.\nRun it, then get the verification code then try again.', 
                ephemeral: true 
            });

            command_status.status = "failed";
        } 
        
        if(interaction.options.getString('username') == null && command_status.status == "success") {
            await interaction.reply({ 
                content: 'You have not put in any `username` argument in the command.\nTry running this command again with the `username` paramater filled out.', 
                ephemeral: true 
            });

            command_status.status = "failed";
        }

        if(command_status.status == "success") {
            const options = {
                hostname: 'beta.subrock.rocks',
                port: 443,
                path: '/api/get_user_info?u=' + interaction.options.getString('username'),
                method: 'GET'
            };

            var request = request("https://" + options.hostname + options.path, function (error, response, body) {
                this.error;
            });

            await interaction.reply({ 
                content: request.body, 
                ephemeral: true 
            });
        }
	} else if (commandName === 'userinfo') {
		await interaction.reply(`Server name: ${interaction.guild.name}\nTotal members: ${interaction.guild.memberCount}`);
	} else if (commandName === 'videoinfo') {
		await interaction.reply('User info.');
	}
});

// Login to Discord with your client's token
client.login(token);