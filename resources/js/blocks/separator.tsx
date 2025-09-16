import { SeparatorRoot } from "@narsil-cms/components/separator";

type SeparatorProps = React.ComponentProps<typeof SeparatorRoot> & {};

function Separator({ ...props }: SeparatorProps) {
  return <SeparatorRoot {...props} />;
}

export default Separator;
