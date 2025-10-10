import { LabelRoot } from "@narsil-cms/components/label";
import { type ComponentProps } from "react";

type LabelProps = ComponentProps<typeof LabelRoot>;

function Label({ ...props }: LabelProps) {
  return <LabelRoot {...props} />;
}

export default Label;
