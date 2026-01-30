import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { LabelRequired, LabelRoot } from "@narsil-cms/components/label";
import { useLocalization } from "@narsil-cms/components/localization";
import { type ComponentProps } from "react";

function Label({
  children,
  required = false,
  ...props
}: ComponentProps<typeof LabelRoot> & { required?: boolean }) {
  const { trans } = useLocalization();

  return (
    <LabelRoot {...props}>
      {children}
      {required ? (
        <Tooltip tooltip={trans("accessibility.required")}>
          <LabelRequired />
        </Tooltip>
      ) : null}
    </LabelRoot>
  );
}

export default Label;
