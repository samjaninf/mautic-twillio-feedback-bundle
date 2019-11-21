# Twillio feedback for Mautic 

## Installation

### Manual

1. Use last version
2. Unzip files to plugins/MauticTwilioFeedbackBundle
3. Clear cache (app/cache/prod/)
4. Go to /s/plugins/reload

## Usage

1. Go to Mautic > Settings > Plugins
2. You should see new Twillio feedback
3. Enable it and copy callback URL

<img src="https://user-images.githubusercontent.com/462477/69326000-5cf71a80-0c4b-11ea-9563-fa2f509c5371.png" width="400">

4. Go to Twilio and set that url to **REQUEST URL of phone number** or to **Messaging Services** (attach Phone number to Messaging Services) 

<img src="https://user-images.githubusercontent.com/462477/69040443-19ec3b80-09ee-11ea-9185-87a452c41c92.png" width="400">

5. If you need use any other app to process replies too, you can set these URLs to plugin settings. This forawrd request to another callback URLs

<img src="https://user-images.githubusercontent.com/462477/69326091-83b55100-0c4b-11ea-916d-2b51c314eeba.png" width="400">

## More Mautic stuff

- Plugins from Mautic Extendee Family  https://mtcextendee.com/plugins
- Mautic themes https://mtcextendee.com/themes
