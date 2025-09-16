import { ToggleRoot } from "@narsil-cms/components/toggle";

type ToggleProps = React.ComponentProps<typeof ToggleRoot> & {};

function Toggle({ ...props }: ToggleProps) {
  return <ToggleRoot {...props} />;
}

export default Toggle;
