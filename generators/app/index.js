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
        message: 'Name your theme?',
        default: 'cwf'
      },
      {
        type: 'String',
        name: 'themeName',
        message: "What's your theme machine name?",
        default: function(props) {
          return _.snakeCase(props.humanName);
        },
      },
      {
        type: 'list',
        name: 'bsCSS',
        message: "Copy Bootstrap SCSS to theme?",
        choices: ['Complete','Grid only','Do not copy']
      },
      {
        when: function (response) {
          return response.bsCSS === 'Complete';
        },
        type: 'confirm',
        name: 'bsJS',
        message: "Copy Bootstrap JS to theme?",
        default: true
      },
      {
        type: 'confirm',
        name: 'iconFont',
        message: "Would you like to create your own Icon Font",
        default: true
      },
    ];

    return this.prompt(prompts).then(props => {
      // To access props later use this.props.someAnswer;
      this.props = props;

      // Adjust Bootstrap files
      switch (this.props.bsCSS) {
        case 'Complete':
          // Install complete Bootstrap and copy files
          this.npmInstall(['bootstrap@^4'], { 'save-dev': true });
          this.props.copyBsCSS = 'sve';
          this.props.copyBsJS = 'js all';
          break;
        case 'Grid only':
          // Install Grid Only Bootstrap and copy
          this.npmInstall(['bootstrap-4-grid'], { 'save-dev': true });
          this.props.copyBsCSS = 'samo grid';
          this.props.copyBsJS = '';
          break;
        default:
      }
    });
  }

  writing() {
    var folders = ['templates', 'dist/fonts', 'dist/images', 'dist/css', 'dist/js', 'src/js', 'src/scss', 'src/images/svg','src/images/icons'];
    folders.forEach(function(folder) {
      mkdirp(folder, function(err) {
        if (err) {
          console.log(err);
        } else {
          console.log('Created directory ' + folder)
        }
      });
    });
    // Theme files
    this.fs.copy(
      this.templatePath('_theme.theme'),
      this.destinationPath(this.props.themeName + '.theme')
    );
    this.fs.copyTpl(
      this.templatePath('_theme.libraries.yml'),
      this.destinationPath(this.props.themeName + '.libraries.yml'),
      this.props
    );
    this.fs.copyTpl(
      this.templatePath('_theme.starterkit.yml'),
      this.destinationPath(this.props.themeName + '.info.yml'),
      this.props
    );
    this.fs.copyTpl(
      this.templatePath('config/install/_theme.settings.yml'),
      this.destinationPath('config/install/' + this.props.themeName + '.settings.yml'),
      this.props
    );
    this.fs.copyTpl(
      this.templatePath('config/schema/_theme.schema.yml'),
      this.destinationPath('config/schema/' + this.props.themeName + '.schema.yml'),
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
  }

  install() {
    if (this.options.skipInstall) {
      this.log('Run npm install && composer install to start working');
    } else {
      this.npmInstall();
    }
  }
};
