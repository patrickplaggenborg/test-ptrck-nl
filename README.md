# test.ptrck.nl

Collection of small PHP scripts and test utilities built over the years for quick testing on the server.

**Original domain:** test.ptrck.nl  
**Status:** Archive/Museum piece - no active development

## 📁 Directory Structure

```
test-ptrck-nl/
├── public/                    # Web-accessible files (DocumentRoot)
│   ├── archive/              # Archived projects
│   │   ├── counter/         # Countdown timer widget
│   │   ├── mapgenerator/    # Map generator utility
│   │   └── stylish/         # Calendar styling assets
│   ├── text/                # Text/image manipulation scripts
│   └── vd/                  # Various design experiments
├── Dockerfile               # Container definition
├── .gitignore               # Git ignore rules
├── README.md                # This file
└── TODO.md                  # Migration checklist
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

### Archive Projects (`archive/`)
- **Counter** - Retro flip countdown timer widget
- **Map Generator** - Google Maps integration utility
- **Stylish** - Calendar styling assets

### Text/Image Utilities (`text/`)
Various image manipulation scripts including blur effects and text overlay.

### Design Experiments (`vd/`)
Collection of HTML/CSS/JS experiments and prototypes including chat interfaces, animations, filters, and UI components.

## 🔒 Security Notes

- Input validation added to image processing scripts
- HTTP URLs updated to HTTPS where applicable
- Error display disabled in production

## 🛠️ Development

This is an archive repository. No active development is planned.

## 📄 License

Private project - no license specified.

