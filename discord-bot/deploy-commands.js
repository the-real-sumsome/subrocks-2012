const { SlashCommandBuilder } = require('@discordjs/builders');
const { REST } = require('@discordjs/rest');
const { Routes } = require('discord-api-types/v9');
const { clientId, guildId, token } = require('./config.json');

const commands = [
	new SlashCommandBuilder()
        .setName('verify')
        .setDescription('You verify your Discord account using this.'),
    new SlashCommandBuilder()
        .setName('verify_confirm')
        .setDescription('COnfirmismdisdifgmdif veirficiiacrion')
        .addStringOption(option => option.setName('username').setDescription('SubRocks username')),
	new SlashCommandBuilder()
        .setName('userinfo')
        .setDescription('Fetches SubRocks user info'),
	new SlashCommandBuilder()
        .setName('videoinfo')
        .setDescription('Fetches SubRocks video info'),
]
	.map(command => command.toJSON());

const rest = new REST({ version: '9' }).setToken(token);

rest.put(Routes.applicationGuildCommands(clientId, guildId), { body: commands })
	.then(() => console.log('Successfully registered application commands.'))
	.catch(console.error);
