import '@/scss/common.scss';
import { Utilities } from './utilities';
import { WpInfo } from './utilities/wpInfo';

Utilities.init();

console.log(WpInfo.get());
