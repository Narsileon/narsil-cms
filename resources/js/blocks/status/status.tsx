import { useLocalization } from "@narsil-cms/components/localization";
import { StatusItem, StatusRoot } from "@narsil-cms/components/status";
import { type ComponentProps } from "react";

type StatusProps = ComponentProps<typeof StatusRoot> & {
  published?: boolean;
  saved?: boolean;
  draft?: boolean;
};

function Status({ draft, published, saved, ...props }: StatusProps) {
  const { trans } = useLocalization();

  return (
    <StatusRoot {...props}>
      {published && <StatusItem className="bg-green-500" tooltip={trans("revisions.published")} />}
      {saved && <StatusItem className="bg-amber-500" tooltip={trans("revisions.saved")} />}
      {draft && <StatusItem className="bg-red-500" tooltip={trans("revisions.draft")} />}
    </StatusRoot>
  );
}

export default Status;
