import { PreviewCard } from "@base-ui/react/preview-card";

function PreviewCardTrigger({ ...props }: PreviewCard.Trigger.Props) {
  return <PreviewCard.Trigger data-slot="preview-card-trigger" {...props} />;
}

export default PreviewCardTrigger;
