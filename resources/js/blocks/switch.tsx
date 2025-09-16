import { SwitchRoot, SwitchThumb } from "@narsil-cms/components/switch";

type SwitchProps = React.ComponentProps<typeof SwitchRoot> & {
  thumbProps?: Partial<React.ComponentProps<typeof SwitchThumb>>;
};

function Switch({ thumbProps, ...props }: SwitchProps) {
  return (
    <SwitchRoot {...props}>
      <SwitchThumb {...thumbProps} />
    </SwitchRoot>
  );
}

export default Switch;
