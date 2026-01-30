import { PreviewCard } from "@base-ui/react/preview-card";

function PreviewCardPortal({ ...props }: PreviewCard.Portal.Props) {
  return <PreviewCard.Portal data-slot="preview-card-portal" {...props} />;
}

export default PreviewCardPortal;
