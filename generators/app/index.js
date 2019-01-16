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
        type: 'String',
        name: 'proxyName',
        message: "What proxy should broweserync use?",
        default: function(props) {
          return _.snakeCase(props.humanName) + '.dev';
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
      {
        type: 'confirm',
        name: 'svgSprite',
        message: "Would you like to use Svg sprites?",
        default: true
      }
    ];

    return this.prompt(prompts).then(props => {
      // To access props later use this.props.someAnswer;
      this.props = props;
    });
  }

  writing() {
    var folders = ['dist/fonts', 'dist/images', 'dist/css', 'dist/js', 'src/scss'];
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
    this.fs.copyTpl(
      this.templatePath('_theme.starterkit.yml'),
      this.destinationPath(this.props.themeName + '.info.yml'),
      this.props
    );

    this.fs.copy(
      this.templatePath('_theme.theme'),
      this.destinationPath(this.props.themeName + '.theme')
    );

    this.fs.copy(
      this.templatePath('_theme.settings.yml'),
      this.destinationPath(this.props.themeName + '.settings.yml')
    );

    this.fs.copyTpl(
      this.templatePath('_theme.libraries.yml'),
      this.destinationPath(this.props.themeName + '.libraries.yml'),
      this.props
    );

    this.fs.copy(
      this.templatePath('templates'),
      this.destinationPath('templates')
    );

    if (this.props.svgSprite) {
      this.fs.append(this.destinationPath('templates/page.html.twig'), '<div class="d-none">{{ source("/" ~ directory ~ "/dist/images/sprite.svg") }}</div>' );
    }

    // Install and schema
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

    // CSS and JS
    this.fs.copyTpl(
      this.templatePath('src/js/_script.js'),
      this.destinationPath('src/js/' + this.props.themeName + '.js'),
      this.props
    );

    // Assets
    this.fs.copy(this.templatePath('static/**/*'), this.destinationRoot(), {
      globOptions: {
        dot: true
      }
    });

    this.fs.copyTpl(
      this.templatePath('logo.svg'),
      this.destinationPath('logo.svg'),
      this.props
    );

    if (this.props.iconFont) {
      this.fs.copy(
        this.templatePath('src/images/icons'),
        this.destinationPath('src/images/icons')
      );
      this.fs.copy(
        this.templatePath('icon-font.hbs'),
        this.destinationPath('icon-font.hbs'),
      );
    }

    if (this.props.svgSprite) {
      this.fs.copy(
        this.templatePath('src/images/svg'),
        this.destinationPath('src/images/svg')
      );
    }

    this.fs.copyTpl(
      this.templatePath('_package.json'),
      this.destinationPath('package.json'),
      this.props
    );
  }

  install() {
    // Adjust Bootstrap files
    switch (this.props.bsCSS) {
      case 'Complete':
        // Install complete Bootstrap and copy files
        this.npmInstall(['bootstrap@^4'], { 'save-dev': true });
        break;
      case 'Grid only':
        // Install Grid Only Bootstrap and copy
        this.npmInstall(['bootstrap-4-grid'], { 'save-dev': true });
        break;
      default:
    }

    if (this.options.skipInstall) {
      this.log('Run npm install to start working');
    } else {
      this.npmInstall();
    }
  }

  end() {
    console.log(this.props.bsCSS);
    // Copy all Bootstrap SCSS files
    if (this.props.bsCSS === 'Complete') {
      this.fs.copy(
        this.destinationPath('node_modules/bootstrap/scss/bootstrap.scss'),
        this.destinationPath('src/scss/' + this.props.themeName + '.scss'),
      );
      this.fs.copy(
        this.destinationPath('node_modules/bootstrap/scss/**/_*.scss'),
        this.destinationPath('src/scss'),
      );
    }
    // Copy only Bootstrap grid
    if (this.props.bsCSS === 'Grid only') {
      this.fs.copy(
        this.destinationPath('node_modules/bootstrap-4-grid/scss/grid/bootstrap-grid.scss'),
        this.destinationPath('src/scss/' + this.props.themeName + '.scss'),
      );
      this.fs.copy(
        this.destinationPath('node_modules/bootstrap-4-grid/scss/grid/**/_*.scss'),
        this.destinationPath('src/scss'),
      );
    }
    // Copy Bootstrap.js
    if (this.props.bsJS === true) {
      this.fs.copy(
        this.destinationPath('node_modules/bootstrap/dist/js/bootstrap.js'),
        this.destinationPath('src/js/bootstrap.js'),
      );
    }

    if (this.props.iconFont) {
      // Add the icon SCSS to styles
      var scss = this.fs.read('src/scss/' + this.props.themeName + '.scss');
      this.fs.write('src/scss/' + this.props.themeName + '.scss', '@import "icon-font.scss";\n' + scss );
    }

    this.log('Run npm build to start working');
  }
};
