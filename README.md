# test.ptrck.nl

Collection of small PHP scripts and test utilities built over the years for quick testing on the server.

**Original domain:** test.ptrck.nl  
**Status:** Archive/Museum piece - no active development

## 📁 Directory Structure

```
test-ptrck-nl/
├── public/                    # Web-accessible files (DocumentRoot)
│   ├── archive/              # Archived projects
│   │   ├── mt940/           # MT940 banking file parser
│   │   ├── n-builder/       # Website builder tool
│   │   ├── survey/          # Survey form handler
│   │   └── mapgenerator/    # Map generator utility
│   ├── text/                # Text/image manipulation scripts
│   └── vd/                  # Various design experiments
├── private/                  # Config files OUTSIDE web root
│   └── config/              # Configuration files
├── sql/                      # Database files (if needed)
├── docs/                     # Documentation
├── Dockerfile               # Container definition
└── README.md                # This file
```

## 🚀 Deployment

This project is deployed on Coolify using Docker.

### Prerequisites

- Coolify instance
- Docker support

### Deployment Steps

1. **Push to GitHub:**
   ```bash
   git push origin main
   ```

2. **In Coolify:**
   - Link GitHub repository: `patrickplaggenborg/test-ptrck-nl`
   - Build pack: Docker
   - Deploy

3. **Environment Variables:**
   - None required (no database)

4. **Post-Deployment:**
   - Test site loads: `curl https://test.ptrck.nl`
   - Verify SSL certificate
   - Test automated deployment (push changes)

## 📝 Projects Included

### MT940 Parser (`archive/mt940/`)
Banking file parser that converts MT940 format to CSV.

### N-Builder (`archive/n-builder/`)
Visual website builder tool with drag-and-drop interface.

### Survey (`archive/survey/`)
Simple survey form handler with hash code generation.

### Text/Image Utilities (`text/`)
Various image manipulation scripts including blur effects and text overlay.

### Design Experiments (`vd/`)
Collection of HTML/CSS/JS experiments and prototypes.

## 🔒 Security Notes

- XSS vulnerabilities have been fixed in `survey/index.php`
- Input validation added to image processing scripts
- HTTP URLs updated to HTTPS where applicable
- Error display disabled in production

## 🛠️ Development

This is an archive repository. No active development is planned.

## 📄 License

Private project - no license specified.

