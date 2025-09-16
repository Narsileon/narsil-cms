import { ButtonRoot } from "@narsil-cms/components/button";

type ButtonProps = React.ComponentProps<typeof ButtonRoot> & {};

function Button({ ...props }: ButtonProps) {
  return <ButtonRoot {...props} />;
}

export default Button;
