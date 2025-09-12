import { SwitchRoot, SwitchThumb } from "@narsil-cms/components/switch";

type SwitchProps = React.ComponentProps<typeof SwitchRoot> & {};

function Switch({ className, ...props }: SwitchProps) {
  return (
    <SwitchRoot {...props}>
      <SwitchThumb />
    </SwitchRoot>
  );
}

export default Switch;
