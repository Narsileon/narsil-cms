import { LabelRoot } from "@narsil-cms/components/label";

type LabelProps = React.ComponentProps<typeof LabelRoot> & {};

function Label({ ...props }: LabelProps) {
  return <LabelRoot {...props} />;
}

export default Label;
