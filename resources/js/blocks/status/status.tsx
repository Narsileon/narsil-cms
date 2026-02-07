import { StatusItem, StatusRoot } from "@narsil-cms/components/status";
import { useTranslator } from "@narsil-ui/components/translator";
import { type ComponentProps } from "react";

type StatusProps = ComponentProps<typeof StatusRoot> & {
  published?: boolean;
  saved?: boolean;
  draft?: boolean;
};

function Status({ draft, published, saved, ...props }: StatusProps) {
  const { trans } = useTranslator();

  return (
    <StatusRoot {...props}>
      {published && <StatusItem className="bg-green-500" tooltip={trans("revisions.published")} />}
      {saved && <StatusItem className="bg-amber-500" tooltip={trans("revisions.saved")} />}
      {draft && <StatusItem className="bg-red-500" tooltip={trans("revisions.draft")} />}
    </StatusRoot>
  );
}

export default Status;
