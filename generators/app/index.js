'use strict';
const Generator = require('yeoman-generator');
const chalk = require('chalk');
const yosay = require('yosay');
const _ = require('lodash');
const mkdirp = require('mkdirp');

module.exports = class extends Generator {
  prompting() {
    // Have Yeoman greet the user.
    this.log(
      yosay(`Welcome to the badass ${chalk.red('generator-cwf-theme')} generator!`)
    );


    const prompts = [
      {
        type: 'String',
        name: 'humanName',
        message: 'How will you call your theme?',
        default: 'cwf'
      },
      {
        type: 'String',
        name: 'appName',
        message: "What's your cwf machine name?",
        default: function(props) {
          return _.snakeCase(props.humanName);
        },
      },
      {
        type: 'list',
        name: 'bs',
        message: "How would you like to use Bootstrap CSS?",
        choices: ['complete','grid_only','no_css']
      },
      {
        type: 'Boolean',
        name: 'iconFont',
        message: "Would you like to create your own Icon Font",
        default: true
      },
    ];

    return this.prompt(prompts).then(props => {
      // To access props later use this.props.someAnswer;
      this.props = props;
      switch(this.props.bs) {
        case 'complete':
          this.props.copyBs = 'sve';
          break;
        case 'grid_only':
          this.props.copyBs = 'samo grid';
          break;
        default:
      }
    });
  }

  writing() {
    var folders = ['templates', 'dist/fonts', 'dist/images', 'dist/css', 'dist/js', 'src/js', 'src/scss', 'src/images/svg','src/images/icons'];
    folders.forEach(function(folder) {
      mkdirp(folder, function (err) {
        if (err){
          console.log(e);
        } else {
          console.log('Created directory ' + folder)
        }
      });
    });
    // Theme files
    this.fs.copy(
      this.templatePath('_theme.theme'),
      this.destinationPath(this.props.appName + '.theme')
    );
    this.fs.copy(
      this.templatePath('_theme.libraries.yml'),
      this.destinationPath(this.props.appName + '.libraries.yml')
    );
    this.fs.copyTpl(
      this.templatePath('_theme.starterkit.yml'),
      this.destinationPath(this.props.appName + '.info.yml'),
      this.props
    );
    this.fs.copyTpl(
      this.templatePath('config/install/_theme.settings.yml'),
      this.destinationPath('config/install/' + this.props.appName + '.settings.yml'),
      this.props
    );
    this.fs.copyTpl(
      this.templatePath('config/schema/_theme.schema.yml'),
      this.destinationPath('config/schema/' + this.props.appName + '.schema.yml'),
      this.props
    );
    this.fs.copyTpl(
      this.templatePath('logo.svg'),
      this.destinationPath('logo.svg'),
      this.props
    );

    // Assets
    this.fs.copyTpl(
      this.templatePath('_package.json'),
      this.destinationPath('package.json'),
      this.props
    );
    if (this.props.iconFont) {
      this.fs.copy(
        this.templatePath('icons-scss.hbs'),
        this.destinationPath('icons-scss.hbs'),
      );
    };

    console.log('GLHF!');
  }

  install() {
    switch(this.props.bs) {
      case 'complete':
        this.npmInstall(['bootstrap@^4'], { 'save-dev': true });
        break;
      case 'grid_only':
        this.npmInstall(['bootstrap-4-grid'], { 'save-dev': true });
        break;
      default:
    }
    if (this.options.skipInstall) {
      this.log('Run npm install && composer install to start working');
    } else {
      this.npmInstall();
    }
  }
};

