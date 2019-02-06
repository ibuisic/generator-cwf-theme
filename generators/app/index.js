'use strict';

const Generator = require('yeoman-generator');
const chalk = require('chalk');
const yosay = require('yosay');
const _ = require('lodash');
const mkdirp = require('mkdirp');
const textToPicture = require('text-to-picture');

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
      },
      {
        when: function (response) {
          return response.bsCSS === 'Complete';
        },
        type: 'confirm',
        name: 'awsmMixins',
        message: "Add our awesome mixins to Bootstrap?",
        default: true
      },
      {
        type: 'confirm',
        name: 'slickSlider',
        message: "We like and use the slick slider, would you like to add it?",
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

    // Package json
    this.fs.copyTpl(
      this.templatePath('_package.json'),
      this.destinationPath('package.json'),
      this.props
    );

    const pkgJson = {
      scripts: {
        "scss-lint:fix": "stylelint --syntax scss --fix \"src/scss/**/*.scss\"",
        "lint:js": "eslint src/js",
        "lint:fix": "eslint src/js --fix",
        "image:min": "imagemin src/images/* --out-dir=dist/images",
        "css:scss-lint": "stylelint --syntax scss \"src/scss/**/*.scss\"",
        "css:scss": "node-sass --output-style compressed -o dist/css src/scss",
        "css:prefix": "postcss -u autoprefixer -r dist/css/*",
        "serve": "browser-sync start --proxy \""+ this.props.proxyName +"\" --files \"dist/css/*.css, src/js/*.js, templates/**/*.twig, !node_modules/**/*.html\"",
      }
    };

    // Theme files
    this.fs.copyTpl(
      this.templatePath('_theme.starterkit.yml'),
      this.destinationPath(this.props.themeName + '.info.yml'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('_theme.theme'),
      this.destinationPath(this.props.themeName + '.theme'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('_theme.libraries.yml'),
      this.destinationPath(this.props.themeName + '.libraries.yml'),
      {
        BootstrapJS: this.props.bsJS ? 'dist/js/bootstrap.js: {}' : '//unpkg.com/bootstrap/dist/js/bootstrap.min.js : { type: external, minified: true }',
        themeName: this.props.themeName,
        slickSlider: this.props.slickSlider
          ? this.fs.read(this.templatePath('_slick.yml'))
          : ''
      }
    );

    this.fs.copyTpl(
      this.templatePath('theme-settings.php'),
      this.destinationPath('theme-settings.php'),
      this.props
    );

    this.fs.copy(
      this.templatePath('templates'),
      this.destinationPath('templates')
    );

    this.fs.copyTpl(
      this.templatePath('src/Theme/*.php'),
      this.destinationPath('src/Theme/'),
      this.props,
      { globOptions: { dot: true } }
    );

    if (this.props.svgSprite) {
      this.fs.append(this.destinationPath('templates/page.html.twig'), '<div class="d-none">{{ source("/" ~ directory ~ "/dist/images/sprite.svg") }}</div>' );
    }

    if (this.props.slickSlider) {
      this.fs.write(this.destinationPath('src/scss/slick.scss'), '// Slick Slider');
    }

    // Install, schema and optional configs
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
      this.templatePath('config/optional/_block.block.theme_branding.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_branding.yml'),
      this.props
    );
    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_main_menu.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_main_menu.yml'),
      this.props
    );
    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_search.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_search.yml'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_account_menu.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_account_menu.yml'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_breadcrumbs.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_breadcrumbs.yml'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_content.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_content.yml'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_footer.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_footer.yml'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_help.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_help.yml'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_local_actions.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_local_actions.yml'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_local_tasks.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_local_tasks.yml'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_messages.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_messages.yml'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_page_title.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_page_title.yml'),
      this.props
    );

    this.fs.copyTpl(
      this.templatePath('config/optional/_block.block.theme_tools.yml'),
      this.destinationPath('config/optional/block.block.' + this.props.themeName + '_tools.yml'),
      this.props
    );

    // CSS and JS
    this.fs.copyTpl(
      this.templatePath('src/js/_script.js'),
      this.destinationPath('src/js/' + this.props.themeName + '.js'),
      this.props
    );
    this.fs.copyTpl(
      this.templatePath('src/js/addons'),
      this.destinationPath('src/js/addons'),
      this.props
    );

    this.fs.copy(
      this.templatePath('./src/scss/addons'),
      this.destinationPath('./src/scss/addons')
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
      this.fs.copyTpl(
        this.templatePath('icon-html.hbs'),
        this.destinationPath('icon-html.hbs'),
        this.props
      );
      // Add packages
      this.npmInstall(['icon-font-generator'], { 'save-dev': true });
      // Create scripts
      pkgJson.scripts["image:icons"] =
        "icon-font-generator src/images/icons/*.svg --html true --htmlpath " + this.props.themeName + "-test-page.html --htmltp ./icon-html.hbs  -o dist/fonts/ -f ../fonts --csstp ./icon-font.hbs -p glyph -t glyph --csspath src/scss/_icon-font.scss";
      pkgJson.scripts["watch:icons"] =
        "nodemon --watch src/images/icons -e svg -x \"npm run image:icons\"";
    } else {
      this.fs.copyTpl(
        this.templatePath('_theme-test-page.html'),
        this.destinationPath(this.props.themeName + '-test-page.html'),
        this.props
      );
    }

    if (this.props.svgSprite) {
      this.fs.copy(
        this.templatePath('src/images/svg'),
        this.destinationPath('src/images/svg')
      );
      // Add packages
      this.npmInstall(['svg-sprite-generator'], { 'save-dev': true });
      // Create scripts
      pkgJson.scripts["image:sprite"] =
        "svg-sprite-generate -d src/images/svg -o dist/images/sprite.svg";
      pkgJson.scripts["watch:svg"] =
        "nodemon --watch src/images/svg -e svg -x \"npm run image:sprite\"";
    }

    // Create screenshot
    textToPicture
      .convert({
        text: this.props.humanName,
        source: {
          width: 300,
          height: 300,
          background: 0x367588
        },
        color: 'white'
      })
      .then(result => {
        return result.write(this.destinationPath('screenshot.png'))
      })
      .catch(err => err);

    // Add build package JSON

    pkgJson.scripts["build:images"] = "run-s image:*";
    pkgJson.scripts["build:js"] = "uglifyjs src/js/" + this.props.themeName + ".js" + " -o dist/js/" + this.props.themeName + ".min.js --source-map url=" + this.props.themeName + ".min.js.map";
    pkgJson.scripts["build:css"] = "run-s css:scss css:prefix";
    pkgJson.scripts.build = "run-s build:*";
    pkgJson.scripts["watch:css"] = "nodemon --watch src/scss -e scss -x \"run-s -s css:*\"";
    pkgJson.scripts["watch:images"] = "nodemon --watch src/images -x \"npm run image:min\"";
    pkgJson.scripts.watch = "run-p serve watch:*";

    // Updated package Json with scripts used
    this.fs.extendJSON(this.destinationPath('package.json'), pkgJson);
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
    } else if (this.props.bsCSS === 'Grid only') {
      this.fs.copy(
        this.destinationPath('node_modules/bootstrap-4-grid/scss/grid/bootstrap-grid.scss'),
        this.destinationPath('src/scss/' + this.props.themeName + '.scss'),
      );
      this.fs.copy(
        this.destinationPath('node_modules/bootstrap-4-grid/scss/grid/**/_*.scss'),
        this.destinationPath('src/scss'),
      );
      // Nothing
    } else {
      this.fs.write(
        this.destinationPath('src/scss/' + this.props.themeName + '.scss'), '', function (err) {
          if (err) throw err;
          console.log('Created main scss file!');
        }
      );
    }
    // Copy Bootstrap.js
    if (this.props.bsJS === true) {
      this.fs.copy(
        this.destinationPath('node_modules/bootstrap/dist/js/bootstrap.js'),
        this.destinationPath('dist/js/bootstrap.js'),
      );
    }

    // Add Awesome mixins
    if (this.props.awsmMixins) {
      this.fs.copy(
        this.templatePath('_theme-mixins.scss'),
        this.destinationPath('./src/scss/_' + this.props.themeName + '-mixins.scss')
      );
    }

    var scssFile = this.fs.read('src/scss/' + this.props.themeName + '.scss');

    const cssImports = `// Main ${this.props.humanName} SCSS file\n\n${this.props.iconFont ? `@import "icon-font.scss";\n\n` : ''}${this.props.awsmMixins ? `@import "${this.props.themeName}-mixins.scss";\n\n`: ''}`;

    this.fs.write(
      this.destinationPath('src/scss/' + this.props.themeName + '.scss'),
      cssImports + scssFile
    );

    console.log(cssImports + scssFile);

    // Build all after copied all files
    this.spawnCommand('npm', ['run', 'build']);
  }
};
