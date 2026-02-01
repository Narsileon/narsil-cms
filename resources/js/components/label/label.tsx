import { LabelRequired, LabelRoot } from "@narsil-cms/components/label";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { type ComponentProps } from "react";

type LabelProps = ComponentProps<typeof LabelRoot> & {
  required?: boolean;
  requiredLabel?: string;
};

function Label({ children, required = false, requiredLabel = "Required", ...props }: LabelProps) {
  return (
    <LabelRoot {...props}>
      {children}
      {required ? (
        <Tooltip tooltip={requiredLabel}>
          <LabelRequired />
        </Tooltip>
      ) : null}
    </LabelRoot>
  );
}

export default Label;
