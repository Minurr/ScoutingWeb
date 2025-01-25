# IM-Scout Web V2.4.0
#### Design by FRC#5516.

IM-Scout(ScoutWeb) is a scouting website for FRC/FTC teams, designed to upload, query, and analyze scouting data. This making it easier for users to manage scouting data.

IM-Scout(ScoutWeb) 是为 FRC/FTC 队伍设计的侦察网站，用于上传、查询和分析侦察数据。这使用户更容易管理侦察数据。

---

## Key Features 主要功能

### Data Management 数据管理
- **Data Upload & Query**: Effortlessly upload scouting data and query historical records based on team codes.
- **数据上传和查询**: 轻松上传侦察数据，并根据队伍编号查询历史数据。
  
### Video Integration 视频整合
- **Video Upload**: Link match videos with corresponding scouting data for comprehensive review. Videos are uploaded via a streamlined API.
- **视频上传**: 将比赛视频与相应的侦察数据连接起来，以便进行全面分析和赛后复盘。视频通过精简的应用程序接口上传。

### Intelligent Analytics 智能分析
- **Automated Insights Datas**: Leverage advanced algorithms to analyze data, offering actionable insights and strategy suggestions for teams and alliances.
- **自动分析数据**: 利用IronMaple先进的算法分析数据和前置语，为团队和联盟提供可行的见解和战略建议，节省赛后分析时间。

### User Management 用户管理
- **Role-Based Access**: A robust user system with group-based task assignments and permission management. Security is enhanced using REG-codes to restrict unauthorized access, unnecessary resource consumption is avoided.
- **权限访问**: 一个强大的用户系统，具有基于组的任务分配和权限管理功能。使用 REG 代码限制未经授权的组、用户注册，增强了安全性，避免了不必要的资源消耗。

### UI/UX Enhancements 用户界面/体验增强
- **Sleek Design**: The UI has been revamped with a modern, Material Design-inspired style, delivering an intuitive and user-friendly experience.
- **流畅设计**: 用户图形界面采用了受 Google Material You 启发的现代风格，使用了特定的主题颜色，提供了直观和用户友好的体验。
---

## System Requirements 环境配置

- **PHP Version**: ≥7.4
- **Nginx Version**: =1.24.0

---

## Server Setup 服务器配置

The system runs on PHP and Nginx. Please ensure your server meets the required versions for optimal performance.
系统使用 PHP 和 Nginx。请确保您的服务器符合所需的版本，以获得最佳性能，如您使用宝塔面板，可直接导入使用。

---

## How to Use 如何使用？

1. **Set Up the Environment 设置环境**:  
    Make sure your server meets the required PHP and Nginx versions. After setting up, deploy the website.
    确保服务器符合所需的 PHP 和 Nginx 版本。设置完成后，部署网站。

2. **Change Config 更改配置**:
    Change the API link within /view/index.php and the preamble to ensure smart analytics are available.
    更改/view/index.php内的API链接以及前置语，以确保智能分析功能可用。

3. **Change Forms 更改表单**:
   After logging into your administrator account, visit the /admin page to change the Scouting form. Or just open /config.php to change the form.
   登录管理员账号后，访问/admin页更改Scouting表单。或直接打开/config.php更改表单。

4. **User Registration 用户注册**:  
    Register using the REG-code for security. After registration, users are assigned tasks and permissions based on their group.
    使用 REG 代码进行安全注册。注册后，将根据用户组为其分配任务和权限。

5. **Data Upload 数据上传**:  
    Once logged in, users can upload scouting data and associate it with match videos.
    登录后，用户可以上传球探数据，并将其与比赛视频相关联。

6. **Intelligent Analysis 智能分析**:  
    After data upload, the system will automatically analyze the data and generate suggestion tables for teams and alliances.
    数据上传后，系统将自动分析数据，并为团队和联盟生成建议表。


---

## Contributing 帮助我们

If you'd like to contribute to IM-Scout(ScoutWeb), feel free to submit a Pull Request or open an Issue. We welcome any suggestions or improvements!
如果你想为 IM-Scout(ScoutWeb) 做出贡献，请随时提交 Pull Request 或打开一个 Issue。我们欢迎任何建议或改进！

---

## License 许可证

IM-Scout(ScoutWeb) is licensed under the [MIT License](https://opensource.org/licenses/MIT).
IM-Scout 使用 [MIT License](https://opensource.org/licenses/MIT) 开源许可协议。

---

<footer>
    <div class="footer-content">
        <div class="footer-sponsor">
            <p>Server Sponsorship 服务器赞助: </p>
        </div>
        <div class="footer-logo">
            <img src="https://api4.lfcup.cn/files/logo2.png" alt="Logo" class="logo" width="200" height="auto">
        </div>
    </div>
</footer>
