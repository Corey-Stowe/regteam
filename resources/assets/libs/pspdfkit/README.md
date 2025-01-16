# Nutrient Web SDK (previously PSPDFKit)

**PDF SDK for document viewing and editing in the browser**

Nutrient Web SDK (previously PSPDFKit for Web) is a secure [JavaScript PDF library][] for viewing, annotating, and editing PDFs, Office documents, TIFFs, JPGs, and PNGs directly in the browser. It offers developers a way to quickly add document and image functionality to any web application. There are many [awesome][awesome nutrient] [examples][], and it comes supported by the amazing team at [Nutrient][company about]. Our PDF SDK is fully compatible with [React][], [Angular][], [Vue][], [Svelte][], [Next.js][], [Nuxt][], [Vite][], [Electron][], and any other [JavaScript][] or [TypeScript][] framework.

Nutrient Web SDK can also be integrated into your [Salesforce][] instance, as well as Microsoft [Sharepoint][], [Teams][], and [OneDrive][].

- **Customizable** — Robust API for configuring behavior and appearance
- **Client-side** — Workload is offloaded to client (no server needed)
- **Secure** — Battle-tested, reliable PDFium-based PDF rendering engine
- **Office document support** — View and convert Office documents without third-party dependencies

<img src="https://www.nutrient.io/images/intercom/pspdfkit-npm.png" alt="Image showcasing the popular features of Nutrient Web SDK" width="100%" />

## Getting started

The guide below explains how to integrate our Web PDF SDK into a Vanilla JavaScript project. For other scenarios, refer to the [step-by-step guides][guides gs].

1. Go to your project's root folder and run the following command in the terminal. It installs the Nutrient npm package and adds it as a project dependency:

```npm
npm install --save pspdfkit
```

2. Run the following command to copy the Nutrient Web SDK distribution to the `assets` directory in your project’s root folder:

```bash
cp -R ./node_modules/pspdfkit/dist/ ./assets/
```

3. Rename the PDF document you want to display in your application to `document.pdf`, and then add the PDF document to your project’s root directory. You can use [this demo document][demo document] as an example.

4. Add an empty `<div>` element with a defined width and height to where Nutrient Web SDK will be mounted:

```html
<div id="pspdfkit" style="width: 100%; height: 100vh;"></div>
```

5. Add the following code to the main JavaScript file of your application. This imports and instantiates Nutrient Web SDK:

```js
import "./assets/pspdfkit.js";

const baseUrl = `${window.location.protocol}//${window.location.host}/assets/`;

PSPDFKit.load({
  baseUrl,
  container: "#pspdfkit",
  document: "document.pdf"
});
```

## Web demos

- [Document viewing][]
- [Customizable UI][]
- [Adding annotations][]
- [Filling PDF forms][]
- [Creating PDF forms][]
- [Signatures][]
- [Document editing][]
- [Document generation][]
- [Generate PDFs from DOCX templates][]
- [Real-time collaboration][]
- And [more][]

## File type support

Nutrient Web SDK enables client-side viewing and conversion of PDF, Word, Excel, PowerPoint, TIFF, JPG, and PNG files directly on any browser — no server dependencies or MS Office licenses are required.

- PDF, PDF/A (1, 2, 3, 4)
- DOCX, DOC, DOTX, DOCM, XLSX, XLS, XLSM, PPTX, PPT, PPTM
- PNG, JPEG, JPG, TIFF, TIF

## Browser support

Our PDF SDK supports the latest versions of all commonly used browsers: Chrome, Mozilla Firefox, Safari, Edge, and Firefox ESR.

## Integrations

Nutrient Web SDK is compatible with Salesforce, SharePoint, Microsoft Teams, and Microsoft OneDrive.

## Documentation

Nutrient offers comprehensive [guides][guides docs] and [code samples][] to help you quickly integrate and customize your application. It comes with [full technical support][support] that includes direct access to the engineers who built the product. Whether you have questions getting started with our PDF SDK, or you want to know how to best integrate new features into your app, we’re here to help you find a solution.

Most popular guides:

- [PDF viewer][]
- [Office conversion][]
- [Annotation][]
- [Forms][]
- [Signatures][]
- [Editor][]
- [PDF generation][]
- [Conversion][]
- [Extraction][]
- [Redaction][]
- [Document security][]
- [Search][]

## API

[Read the full API reference][api reference].

## Changelog

For a detailed list of the changes included in each version, refer to the [changelog][].

## License and support

Nutrient is a commercial product that offers a [free trial license][trial] to evaluate and integrate it into your product. Visit our [pricing page][pricing] to learn more about licensing our solution.

Copyright © 2010-2024 PSPDFKit GmbH.

[javascript pdf library]: https://www.nutrient.io/guides/web/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[awesome nutrient]: https://github.com/PSPDFKit/awesome-nutrient?tab=readme-ov-file#web
[examples]: https://www.nutrient.io/guides/web/samples/
[company about]: https://www.nutrient.io//company/about/
[react]: https://www.nutrient.io//getting-started/web/?frontend=react&project=new-project
[angular]: https://www.nutrient.io//getting-started/web/?frontend=angular&project=new-project
[vue]: https://www.nutrient.io//getting-started/web/?frontend=vuejs&project=new-project
[svelte]: https://www.nutrient.io//getting-started/web/?frontend=svelte&project=new-project
[next.js]: https://www.nutrient.io//getting-started/web/?frontend=nextjs&download=npm&integration=global-variable&project=new-project
[nuxt]: https://www.nutrient.io/getting-started/web/?frontend=nuxtjs&download=npm&integration=global-variable&project=new-project
[vite]: https://www.nutrient.io/getting-started/web/?frontend=vite&download=npm&integration=global-variable&project=new-project
[electron]: https://www.nutrient.io/getting-started/web/?frontend=electron&download=npm&integration=global-variable&project=new-project
[javascript]: https://www.nutrient.io/getting-started/web/?frontend=vanillajs&download=npm&integration=global-variable
[typescript]: https://www.nutrient.io/getting-started/web/?frontend=typescript&download=npm&integration=global-variable&project=new-project
[salesforce]: https://www.nutrient.io/getting-started/web-integrations/?product=salesforce&project=new-project
[sharepoint]: https://www.nutrient.io/getting-started/web-integrations/?product=sharepoint&deployment=on-premises&project=new-project
[teams]: https://www.nutrient.io/getting-started/web-integrations/?product=teams
[onedrive]: https://www.nutrient.io/getting-started/web-integrations/?product=onedrive
[guides gs]: https://www.nutrient.io/getting-started/web/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[demo document]: https://www.nutrient.io/downloads/pspdfkit-web-demo.pdf
[document viewing]: https://www.nutrient.io/demo/viewer?utm_source=npm&utm_medium=referral&utm_campaign=readme
[customizable ui]: https://www.nutrient.io/demo/ui
[adding annotations]: https://www.nutrient.io/demo/annotations?utm_source=npm&utm_medium=referral&utm_campaign=readme
[filling pdf forms]: https://www.nutrient.io/demo/forms?utm_source=npm&utm_medium=referral&utm_campaign=readme
[creating pdf forms]: https://www.nutrient.io/demo/pdf-form-creator
[signatures]: https://www.nutrient.io/demo/signatures?utm_source=npm&utm_medium=referral&utm_campaign=readme
[document editing]: https://www.nutrient.io/demo/editor?utm_source=npm&utm_medium=referral&utm_campaign=readme
[document generation]: https://www.nutrient.io/demo/document-generation
[generate pdfs from docx templates]: https://www.nutrient.io/demo/generation-from-office-template
[real-time collaboration]: https://www.nutrient.io/demo/instant-collaboration?utm_source=npm&utm_medium=referral&utm_campaign=readme
[more]: https://www.nutrient.io/demo/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[guides docs]: https://www.nutrient.io/guides/web/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[code samples]: https://www.nutrient.io/guides/web/samples/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[support]: http://www.nutrient.io/support/request/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[pdf viewer]: https://www.nutrient.io/guides/web/viewer/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[office conversion]: https://www.nutrient.io/guides/web/conversion/office-to-pdf/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[annotation]: https://www.nutrient.io/guides/web/annotations/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[forms]: https://www.nutrient.io/guides/web/forms/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[signatures]: https://www.nutrient.io/guides/web/signatures/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[editor]: https://www.nutrient.io/guides/web/editor/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[pdf generation]: https://www.nutrient.io/guides/web/pdf-generation/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[conversion]: https://www.nutrient.io/guides/web/conversion/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[extraction]: https://www.nutrient.io/guides/web/extraction/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[redaction]: https://www.nutrient.io/guides/web/redaction/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[document security]: https://www.nutrient.io/guides/web/document-security/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[search]: https://www.nutrient.io/guides/web/search/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[api reference]: https://www.nutrient.io/api/web/PSPDFKit.html
[changelog]: https://www.nutrient.io/changelog/web/?utm_source=npm&utm_medium=referral&utm_campaign=readme
[trial]: https://www.nutrient.io/try/
[pricing]: https://www.nutrient.io/sdk/pricing
