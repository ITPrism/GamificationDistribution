Gamification Platform Distribution
==========================
( Version 2.1 )
- - -

Distribution of [Gamification Platform](http://itprism.com/free-joomla-extensions/ecommerce-gamification/game-mechanics-platform) installed on Joomla 3.6.0. It should be used as development environment where everyone can contribute a code to the project.

##Documentation
You can find documentation on following pages.

[Documentation and FAQ](http://itprism.com/help/101-gamification-platform-documentation)

[API documentation](http://cdn.itprism.com/api/gamification/index.html)

##Download
You can [download Gamification Platform package](http://itprism.com/free-joomla-extensions/ecommerce-gamification/game-mechanics-platform) from the website of ITPrism.

##License
Gamification Platform is under [GPLv3 license](http://www.gnu.org/licenses/gpl-3.0.en.html).

##How to install the distribution and contribute a code?
If you would like to add new feature to the extension or you would like to fix an issue, you should send pull request. How to do it?

* [Fork](https://help.github.com/articles/fork-a-repo/) this repository. That will create a copy in your GitHub account.
* [Clone the repository](https://help.github.com/articles/cloning-a-repository/), that you have just forked, on your PC.
* [Install the distribution like Joomla!](https://docs.joomla.org/J3.x:Installing_Joomla) on your localhost. Note: You should not remove the folder 'installation' on the last step of the installation process.
* Change the value of constant **DEV\_STATUS** to '**dev**' in that file *__libraries/cms/version/version.php__*.
* The installer could remove some files or folders (joomla.xml, robots.txt.dist, /installation). You will have to [revert the files](https://www.quora.com/How-can-I-recover-a-file-I-deleted-in-my-local-repo-from-the-remote-repo-in-Git).
* [Create branch](https://git-scm.com/book/en/v2/Git-Branching-Basic-Branching-and-Merging) and write your code. Use this branch to provide your contribution.
* If you would like to exclude files that you do not want to commit, you will have to use [explicit repository excludes](https://help.github.com/articles/ignoring-files/#explicit-repository-excludes).
* When you are done, [push your branch](https://help.github.com/articles/pushing-to-a-remote/) to your remote (forked) repository.
* Go to your repository and [create pull request](https://help.github.com/articles/using-pull-requests/).

##Branches
There are two general branches - __master__ and __develop__. The master branch contains the stable code. The "develop" is a branch where we will merge all pull requests. You should use the "develop" branch as development environment on your localhost. There will be "release" branches where we will prepare newest releases for publishing.

## How to create Gamification Platform package?
If you would like to create a package that you will be able to install on your Joomla site, you should follow next steps.

* You should install [ANT](http://ant.apache.org/) on your PC.
* Download or clone the code from this repository.
* Download or clone [Gamification Platform package] (https://github.com/ITPrism/GamificationPlatform).
* Rename the file __build/example.txt__ to __build/antconfig.txt__.
* Edit the file __build/antconfig.txt__. Enter name and version of your package. Enter the folder where the source code is (Gamification Platform distribution). Enter the folder where the source code of the package will be stored (the folder where you have saved this repository).
* Save the file __build/antconfig.txt__.
* Open a console and go in folder __build__.
* Type `ant` and click enter. The system will copy all files from distribution to the folder where you are going to build the installable package.

`ant`