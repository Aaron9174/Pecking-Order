# Pecking-Order

Simple Card Game

1. download github desktop<br />
https://desktop.github.com/ <br />

2. using the git shell navigate to a directory where you want to put the git repository <br />
ex. cd Documents/COP4331/PeckingOrder<br />
3. type in these commands<br />
git init (this initiates that folder to be a github repository)<br />
git clone https://github.com/Aaron9174/Pecking-Order (downloads all of the files from the master branch to your computer)<br />

you now have all of the files from the master branch in your local repository<br />
from there everybody will be working on a seperate scene in a seperate branch<br />

4. use these commands in order<br />
git remote add origin https://github.com/Aaron9174/Pecking-Order (adds the repository as a remote reference)<br />
git checkout -b <name of your scene> (this creates a local branch)<br />
----<br />
when you are working on your scene and you make progress and want to push to github use these commands<br />
git checkout [name of your local branch]<br />
git add -A<br />
git commit (it'll ask you to write a message at the top, write it and then save the file)<br />
git push origin [name of your branch]<br />

