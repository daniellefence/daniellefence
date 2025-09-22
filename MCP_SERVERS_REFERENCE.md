# MCP Servers Reference Guide

## What are MCP Servers?

Model Context Protocol (MCP) servers enable AI agents to interact with various platforms, services, and data sources through a standardized interface. They provide secure, controlled access to tools and information across different domains.

## Available MCP Servers

### 🌩️ Cloud & Enterprise Services

**Azure**
- **Purpose**: Access Azure services like Storage, Cosmos DB, and Azure CLI
- **Use Cases**: Cloud resource management, database operations, file storage
- **When to Use**: Working with Microsoft cloud infrastructure

**AWS**
- **Purpose**: Specialized servers bringing AWS best practices to development workflows
- **Use Cases**: EC2 management, S3 operations, Lambda functions
- **When to Use**: Managing Amazon cloud services

**Alibaba Cloud**
- **Purpose**: Multiple servers for DataWorks, OpenSearch, and resource management
- **Use Cases**: Chinese cloud infrastructure, analytics platforms
- **When to Use**: Working with Alibaba cloud ecosystem

### 🛠️ Development & CI/CD Tools

**Buildkite**
- **Purpose**: Exposing pipeline, build, job, and test data to AI tooling
- **Use Cases**: Build monitoring, CI/CD pipeline management
- **When to Use**: Managing continuous integration workflows

**Azure DevOps**
- **Purpose**: Interact with repositories, work items, builds, releases
- **Use Cases**: Project management, code repository operations
- **When to Use**: Working with Microsoft DevOps platform

**Bitrise**
- **Purpose**: Chat with builds, CI, and development processes
- **Use Cases**: Mobile app CI/CD, build automation
- **When to Use**: Managing mobile development workflows

**Git**
- **Purpose**: Git repository management and operations
- **Use Cases**: Version control, branch management, commit operations
- **When to Use**: Any project requiring Git integration

### 📊 Data & Analytics Platforms

**Apache Doris**
- **Purpose**: MPP-based real-time data warehouse integration
- **Use Cases**: Real-time analytics, data warehousing
- **When to Use**: Large-scale data processing and analytics

**DataStax Astra DB**
- **Purpose**: Comprehensive NoSQL database management tools
- **Use Cases**: Cassandra database operations, distributed data storage
- **When to Use**: Working with NoSQL databases

**Axiom**
- **Purpose**: Query and analyze logs, traces, and event data
- **Use Cases**: Log analysis, system monitoring, observability
- **When to Use**: Debugging and system monitoring

### 📝 Productivity & Collaboration

**Atlassian**
- **Purpose**: Securely interact with Jira and Confluence
- **Use Cases**: Project management, documentation, issue tracking
- **When to Use**: Managing Atlassian-based workflows

**Cal.com**
- **Purpose**: Schedule and manage bookings and appointments
- **Use Cases**: Calendar management, meeting scheduling
- **When to Use**: Automating scheduling workflows

**Box**
- **Purpose**: Intelligent content management platform interaction
- **Use Cases**: File sharing, document collaboration
- **When to Use**: Enterprise file management

### 🌐 Web & Blockchain Services

**Bankless Onchain**
- **Purpose**: Query blockchain data, transaction histories
- **Use Cases**: DeFi analysis, blockchain data retrieval
- **When to Use**: Working with blockchain/crypto applications

**Armor Crypto**
- **Purpose**: Interface with multiple blockchain services
- **Use Cases**: Multi-chain operations, crypto portfolio management
- **When to Use**: Managing cryptocurrency operations

### 🔧 Core System Servers

**Everything**
- **Purpose**: Comprehensive system integration and task processing
- **Use Cases**: Multi-service coordination, complex workflows
- **When to Use**: Need broad system access

**Fetch**
- **Purpose**: Data retrieval and HTTP operations
- **Use Cases**: API calls, web scraping, data collection
- **When to Use**: Making HTTP requests and data fetching

**Filesystem**
- **Purpose**: File system management and operations
- **Use Cases**: File reading/writing, directory operations
- **When to Use**: Any file system interactions needed

**Memory**
- **Purpose**: Memory management and caching operations
- **Use Cases**: Data caching, temporary storage
- **When to Use**: Need persistent memory across operations

**Sequential Thinking**
- **Purpose**: Algorithmic and logical processing workflows
- **Use Cases**: Complex decision trees, multi-step processes
- **When to Use**: Require structured thinking processes

**Time**
- **Purpose**: Time-related operations and scheduling
- **Use Cases**: Timestamp management, scheduling, time calculations
- **When to Use**: Working with dates, times, or scheduling

## Installation & Usage

### General Installation Pattern
```bash
# Most servers follow this pattern:
npm install @modelcontextprotocol/server-[name]
# or
pip install mcp-server-[name]
```

### Configuration
1. Install the MCP server
2. Configure authentication (API keys, tokens)
3. Add server to MCP client configuration
4. Initialize connection

## When to Use Each Server

### For Laravel Development (Our Context):
- **Git**: Version control operations
- **Filesystem**: File management, reading/writing project files
- **Fetch**: API integrations, external data retrieval
- **Memory**: Caching development data
- **Time**: Scheduling, timestamp operations

### For Cloud Operations:
- **AWS/Azure**: If using cloud hosting
- **Buildkite/Azure DevOps**: For CI/CD pipelines

### For Data Analysis:
- **Axiom**: Log analysis and monitoring
- **Apache Doris**: If dealing with large datasets

### For Business Operations:
- **Atlassian**: Project management integration
- **Cal.com**: Scheduling automation

## Best Practices

1. **Start Small**: Begin with core servers (git, filesystem, fetch)
2. **Security First**: Always configure proper authentication
3. **Monitor Performance**: MCP servers can impact system performance
4. **Documentation**: Keep track of which servers are configured
5. **Regular Updates**: Keep servers updated for security and features

## Common Use Cases for Our Laravel Project

1. **Development Workflow**:
   - Git server for version control
   - Filesystem for file operations
   - Fetch for API testing

2. **Content Management**:
   - Fetch for external API integrations
   - Memory for caching content

3. **Automation**:
   - Time server for scheduling tasks
   - Sequential thinking for complex workflows

## Quick Reference

| Need | Server | Primary Use |
|------|--------|-------------|
| File Operations | Filesystem | Read/write project files |
| API Calls | Fetch | External integrations |
| Version Control | Git | Repository management |
| Data Caching | Memory | Temporary storage |
| Time Operations | Time | Scheduling/timestamps |
| Complex Logic | Sequential Thinking | Multi-step processes |
| Cloud Services | AWS/Azure | Cloud infrastructure |
| CI/CD | Buildkite/Azure DevOps | Build pipelines |

## Notes for Future Sessions

- MCP servers can be spun up as needed for specific tasks
- Each server provides specific capabilities through standardized tools
- Choose servers based on immediate project needs
- Can combine multiple servers for complex workflows
- Always refer to latest documentation for current capabilities

---

*Reference compiled from https://github.com/modelcontextprotocol/servers*
*Last updated: September 2024*