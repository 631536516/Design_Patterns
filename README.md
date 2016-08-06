##PHP 设计模式
>目前常见的设计模式主要有23种，根据使用目标的不同可以分为以下三大类：<br/>
>创建模式：用于创建对象从而将某个对象从实现中解耦合<br/>
>架构模式：用于在不同的对象之间构造大的对象构造<br/>
>行为模式：用于在不同的对象之间管理算法、关系以及职责<br/>

###Singleton(单例模式)

###Factory(工厂模式)

## PHP 中的接口与抽象类的区别

>对接口的使用方式是通过关键字implements来实现的，而对于抽象类的操作是使用类继承的关键字exotends实现的，使用时要特别注意。<br/>
>接口没有数据成员，但是抽象类有数据成员，抽象类可以实现数据的封装。<br/>
>接口没有构造函数，抽象类可以有构造函数。<br/>
>接口中的方法都是public类型，而抽象类中的方法可以使用private、protected或public来修饰。<br/>
>一个类可以同时实现多个接口，但是只能实现一个抽象类。<br/>
 
>相同点:<br/>
>接口和抽象类都不能直接被实例化<br/>
>函数体内不能写任何东西，连两个大括号都不能写！！！如：function getName();这样就行了【只针对抽象类中的抽象方法 abstract function **】

>抽象类定义:<br/>
>1、类中至少有一个抽象方法
>2、抽象方法不允许有{ }
>3、抽象方法前面必须要加abstract

####区分二者只要记住一句话：【接口是规范，类是实现】。接口的目的是定义一个规范，大家都遵守这个规范。

###Observer(观察者模式)

###Strategy(策略模式)

###CommandChain(命令链模式)

###ObjectPool(对象池模式)

###Prototype(原型模式)

###Proxy(代理模式)

http://www.admin10000.com/document/7115.html

http://blog.csdn.net/jhq0113/article/category/3062707


