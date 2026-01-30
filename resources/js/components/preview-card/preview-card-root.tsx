import { PreviewCard } from "@base-ui/react/preview-card";

function PreviewCardRoot({ ...props }: PreviewCard.Root.Props) {
  return <PreviewCard.Root data-slot="preview-card-root" {...props} />;
}

export default PreviewCardRoot;
