<?php  
header('Content-Type: text/html; charset=utf-8');  
$name = "xxx"; // 修改名字  
?>  
<!DOCTYPE html>  
<html>  
<head>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ensure mobile scaling -->
    <title>情人节快乐 - <?php echo $name; ?></title>  
    <style>  
        body {  
            margin: 0;  
            overflow: hidden;  
            background: #000;  
            font-family: 'Microsoft Yahei', sans-serif;  
            display: flex;  
            justify-content: center;  
            align-items: center;  
            height: 100vh;  
            flex-direction: column;
            text-align: center;
        }  

        #canvas {  
            position: fixed;  
            top: 0;  
            left: 0;  
            width: 100vw;  
            height: 100vh;  
            z-index: 1;  
        }  

        .text-container {  
            position: absolute;  
            width: 100%;  
            text-align: center;  
            color: #fff;  
            z-index: 2;  
            opacity: 0;  
            top: 30%;  
            font-size: 1.5em;
        }  

        .text-container h1, .text-container p {
            margin: 10px 0;
            opacity: 0;
            transform: translateY(50px);
            animation: textFade 1s forwards;
            animation-delay: 0s; /* 移除单个元素的延迟设置 */
        }

        .text-container h1 {
            animation-delay: 3s; /* 标题延迟3秒出现 */
        }

        .text-container p:nth-child(2) {
            animation-delay: 7s; /* 第二行延迟7秒 */
        }

        .text-container p:nth-child(3) {
            animation-delay: 10s; /* 第三行延迟10秒 */
        }

        .text-container p:nth-child(4) {
            animation-delay: 13s; /* 第四行延迟13秒 */
        }

        @keyframes textFade {  
            0% { opacity: 0; transform: translateY(50px); }  
            100% { opacity: 1; transform: translateY(0); }  
        }  

        @keyframes starTwinkle {  
            0% { opacity: 0; }  
            50% { opacity: 1; }  
            100% { opacity: 0; }  
        }  

        .stars {  
            position: fixed;  
            width: 100%;  
            height: 100%;  
            pointer-events: none;  
            z-index: 0;  
            animation: starTwinkle 3s infinite; /* 闪烁动画 */
        }  

        .star {  
            position: absolute;  
            width: 2px;  
            height: 2px;  
            background: #fff;  
            border-radius: 50%;  
            opacity: 0;  
            animation: starTwinkle 4s infinite;  
        }  

        /* Mobile responsive font size adjustment */
        @media (max-width: 600px) {
            .text-container {
                font-size: 1.2em;
            }

            .text-container h1 {
                font-size: 1.8em;
            }

            .text-container p {
                font-size: 1em;
            }
        }
    </style>  
</head>  
<body>  
    <div class="text-container">  
        <h1><?php echo $name; ?>，情人节快乐</h1>  
        <p>你，是我永恒的星辰</p>  
        <p>守护着我每一道光影流转</p>  
        <p>这份爱，如星空般，璀璨</p>  
    </div>  
    <canvas id="canvas"></canvas>  
  
    <script>  
        // 创建背景星光并让其闪烁  
        function createBackgroundStars() {  
            const container = document.createElement('div');  
            container.className = 'stars';  
            document.body.appendChild(container);  
  
            for (let i = 0; i < 300; i++) {  
                const star = document.createElement('div');  
                star.className = 'star';  
                star.style.position = 'absolute';  
                star.style.width = '2px';  
                star.style.height = '2px';  
                star.style.background = '#fff';  
                star.style.borderRadius = '50%';  
                star.style.left = Math.random() * 100 + '%';  
                star.style.top = Math.random() * 100 + '%';  
                star.style.animationDelay = Math.random() * 2 + 's';  
                container.appendChild(star);  
            }  
        }  
  
        // 爱心粒子类  
        class HeartParticle {  
            constructor(canvas) {  
                this.canvas = canvas;  
                this.ctx = canvas.getContext('2d');  
                this.particles = [];  
                this.resize();  
                this.heartPath = [];  
                this.initHeartPath();  
                this.createParticles();  
                this.animate();  
                window.addEventListener('resize', () => this.resize());  
            }  
  
            resize() {  
                this.width = this.canvas.width = window.innerWidth;  
                this.height = this.canvas.height = window.innerHeight;  
            }  
  
            // 创建爱心路径  
            initHeartPath() {  
                for (let t = 0; t < 2 * Math.PI; t += 0.05) {  
                    const x = 16 * Math.pow(Math.sin(t), 3);  
                    const y = -(13 * Math.cos(t) - 5*Math.cos(2*t) - 2*Math.cos(3*t) - Math.cos(4*t));  
                    this.heartPath.push({  
                        x: x * 15 + this.width / 2,  
                        y: y * 15 + this.height / 2  
                    });  
                }  
            }  
  
            // 创建粒子并填充在爱心路径内  
            createParticles() {  
                this.heartPath.forEach(point => {  
                    this.particles.push({  
                        x: point.x,  
                        y: point.y,  
                        color: `hsl(${Math.random() * 30 + 330}, 60%, 65%)`,  // 粒子颜色  
                        speed: 0.02 + Math.random() * 0.05,  
                        targetX: point.x,  
                        targetY: point.y,  
                        alpha: Math.random() * 0.5 + 0.5 // 透明度  
                    });  
                });  
            }  
  
            // 动画更新粒子位置  
            animate() {  
                this.ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';  
                this.ctx.fillRect(0, 0, this.width, this.height);  
  
                // 动画粒子在心形路径内运动  
                this.particles.forEach(p => {  
                    p.x += (p.targetX - p.x) * p.speed;  
                    p.y += (p.targetY - p.y) * p.speed;  
  
                    // 如果粒子靠近目标，随机生成新的目标位置  
                    if (Math.abs(p.x - p.targetX) < 2 && Math.abs(p.y - p.targetY) < 2) {  
                        p.targetX = Math.random() * this.width;  
                        p.targetY = Math.random() * this.height;  
                    }  
                    this.ctx.beginPath();  
                    this.ctx.fillStyle = `rgba(${parseInt(p.color.split(',')[0].slice(4))}, ${parseInt(p.color.split(',')[1])}, ${parseInt(p.color.split(',')[2].slice(0, -1))}, ${p.alpha})`;  
                    this.ctx.arc(p.x, p.y, 2.5, 0, Math.PI * 2);  
                    this.ctx.fill();  
                });  
                requestAnimationFrame(() => this.animate());  
            }  
        }  
  
        window.onload = () => {  
            // 第一步：生成星光并闪烁  
            createBackgroundStars();  
  
            // 第二步：延时3秒后显示文字  
            setTimeout(() => {  
                const textContainer = document.querySelector('.text-container');  
                textContainer.style.opacity = 1;  
            }, 3000);  
  
            // 第三步：延时8秒后生成爱心粒子效果并逐渐消失星光  
            setTimeout(() => {  
                new HeartParticle(document.getElementById('canvas'));  
  
                // 启动后，星光渐渐消失
                const starsContainer = document.querySelector('.stars');
                starsContainer.style.transition = "opacity 2s";  
                starsContainer.style.opacity = 0;  
            }, 15000);  
        };  
    </script>  
</body>  
</html>  
