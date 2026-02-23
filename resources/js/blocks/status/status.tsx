import { StatusItem, StatusRoot } from "@narsil-ui/components/status";
import { Tooltip } from "@narsil-ui/components/tooltip";
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
      {published && (
        <Tooltip tooltip={trans("revisions.published")}>
          <StatusItem className="bg-green-500" />
        </Tooltip>
      )}
      {saved && (
        <Tooltip tooltip={trans("revisions.saved")}>
          <StatusItem className="bg-amber-500" />
        </Tooltip>
      )}
      {draft && (
        <Tooltip tooltip={trans("revisions.draft")}>
          <StatusItem className="bg-red-500" />
        </Tooltip>
      )}
    </StatusRoot>
  );
}

export default Status;
